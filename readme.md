> This library is currently under development. Not ready for production.

## The big idea

A single wrapper API that makes it easy to access and connect Gravity Forms and View data. Everything can be accessed from the `gravityview()` wrapper function.
 
- [ ] Complete the data API
- [ ] Include in GravityView core
- [ ] Complete the template API
- [ ] Use this wrapper function for the REST API endpoint output
- [ ] Continue to migrate core functionality

------------

### Using `gravityview()`

`gravityview()` is a wrapper for the `\GV\Mission_Control` class.

Here's an example:

```
// Get View #12 
$View = gravityview()->views->get(12);

// Get the form connected to View  
$form = $View->get_form();

// Get the `page_size` setting for the View  
$page_size = $View->get_setting('page_size');

// Get the entries for View (returns \GV\Entry_Collection)  
$entries = $View->get_entries();
```

### `\GV\Mission_Control`

The one access point to interact with GravityView.

- `\GV\Request_Parser $parser` handles processing the request, and determines what page/View/entry/search is being performed, and what the current context is (single, multiple, edit)
- `\GV\View_Collection $views` holds View data for Views that have been requested
- `\GV\Form_Collection $forms` holds forms that have been requested
- `\GV\Page_Meta $page_meta` store meta data for the originally-requested page 

### `\GV\View_Collection`

An holder of of `\GV\View` objects.

- `WP_Post $post` The CPT `WP_Post` object for the View
- `\GV\View_Settings $settings` The settings for the View
- `\GV\Template $template` Holds layout configuration for the View. _(Work In Progress)_
- `\GV\Entry_Collection $entry_collection` Entries for the View. Only populated when `get_entries()` is called.

## Usable outside of `gravityview()`

These classes are helpful even when not using the `gravityview()` API.

### The `\GV\Entry()` class

`Entry()` makes it easy to interact with a Gravity Forms entry array. Feed it an entry array when instantiating the class, then additional functionality becomes available:

```
$gf_entry = GFAPI::get_entry( 40 );

$Entry = new \GV\Entry( $entry );

// Get the \GV\Form connected to an entry. Use get_form_array() method to fetch as array.
$Entry->get_form();

// Get the \WP_Post connected to an entry, if exists
$Entry->get_post();

// Get the WP_User object of the entry creator
$created_by = $Entry->get_created_by('wp_user');

// Get the GF_Field object associated with field id #12
$field = $Entry->get_field('12');
```

### Using `\GV\Search_Criteria()`

The `Search_Criteria()` class manages creating valid search requests that can be passed to Gravity Forms.

```
// This will output default search parameters
$Search_Criteria = new \GV\Search_Criteria();

// Then you can add filters
$Search_Criteria->add_filter(array( 'key' => 'id', 'value' => '2', 'operator' => 'isnot' ) );

// Switch between "any" and "all" - no other options are valid
$Search_Criteria->mode->set('any');

// Or you can pass it a current Gravity Forms $search_criteria array, with optional paging and sorting keys as well
$Search_Criteria = new \GV\Search_Criteria( array(
	'field_filters' => array(
		array( 'key' => 'id', 'value' => '2', 'operator' => 'isnot' ),
		array( 'key' => '1.3', 'value' => '221', 'operator' => 'is' )
	),
	'sorting' => array( 'direction' => 'ASC', 'is_numeric' => false ),
	'paging' => array( 'offset' => 12, 'page_size' => 1300 ),
	'mode' => 'all'
));

// Example of using the class in combination with GFAPI::get_entries()
GFAPI::get_entries( 1, $Search_Criteria->get_search_criteria(), $Search_Criteria->sorting->to_array(), $Search_Criteria->paging->to_array() );
```