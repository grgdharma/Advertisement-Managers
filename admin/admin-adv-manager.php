<?php 
/**
* REGISTER ADVERTISE POST TYPE 
* @package WordPress
* @author : Dharma Raj Gurung < gurungdrg30@gmail.com >
* Version: 1.0
*/

add_action('init', 'co_advertise_register');
function co_advertise_register() {
	$labels = array(
		'name' => _x('Advertise', 'post type general name'),
		'singular_name' => _x('Advertise', 'post type singular name'),
		'add_new' => _x('Add New', 'advertise'),
		'add_new_item' => __("Add New Advertise Section"),
		'edit_item' => __("Edit Advertise"),
		'new_item' => __("New Advertise"),
		'view_item' => __("View Advertise"),
		'search_items' => __("Search Advertise"),
		'not_found' =>  __('No advertise found'),
		'not_found_in_trash' => __('No advertise found in Trash'), 
		'parent_item_colon' => ''
	);
	$args = array(
		'labels' => $labels,
		'public' => false,
		'publicly_queryable' => true,
		'show_ui' => true,
		'query_var' => true,
		'rewrite' => true,
		'capability_type' => 'post',
		'hierarchical' => false,
		'menu_position' => null,
		'supports' => array('title','thumbnail')
	  ); 
	register_post_type('advertise',$args );
}


add_filter('manage_edit-advertise_columns', 'advertise_edit_columns');
function advertise_edit_columns($columns) {
    $columns = array(
        "cb" => "<input type=\"checkbox\" />",
        "title" => "Advertise On",
        "short_code" => "Shortcode",
        "author" => "Author",
        "date" => "Date"
    );
    return $columns;
}
add_action('manage_advertise_posts_custom_column', 'advertise_column');
function advertise_column($columns) {
    global $post;
    $custom = get_post_custom($post->ID);

    switch ($columns) {
        case "title":
            echo get_post_title($post->ID);
            break;
        case "short_code":
            echo '<input style="background: transparent; border: none; box-shadow: none; " type="text" onfocus="this.select();" readonly="readonly" value="'.esc_attr('[adv_manager id="'.$post->ID.'" title="'.get_the_title().'"]').'" class="large-text code">';
            break;
    }
}

// Advertise section
add_action('admin_init', 'add_post_advertise_so_14445904');
add_action('admin_head-post.php', 'advertise_print_scripts_so_14445904');
add_action('admin_head-post-new.php', 'advertise_print_scripts_so_14445904');
add_action('save_post', 'update_post_advertise_so_14445904', 10, 2);

/**
 * Add custom Meta Box to Posts post type
 */
function add_post_advertise_so_14445904() {
    add_meta_box('post_advertise', 'Advertise', 'post_advertise_options_so_14445904', 'advertise', 'normal', 'high');
}
/**
 * Print the Meta Box content
 */
function post_advertise_options_so_14445904() {
    global $post;
    $advertise_data = get_post_meta($post->ID, 'advertise_data', true);
    wp_nonce_field(plugin_basename(__FILE__), 'advertise_noncename_so_14445904');
    ?>
    <div id="dynamic_form">
        <div id="field_wrap">
	    <?php
	    	if (isset($advertise_data['image_url'])) {
	        	for ($i = 0; $i < count($advertise_data['image_url']); $i++) {
	            	?>
		            <div class="field_row">
		                <div class="field_left">
		                	<div class="form_field">
			                    <input class="meta_image_title" placeholder="Company name" value="<?php esc_html_e($advertise_data['advertise_title'][$i]); ?>" type="text" name="advertise[advertise_title][]" />
			                </div>
                            <div class="form_field">
                                <input class="meta_image_link" placeholder="Company website" value="<?php esc_html_e($advertise_data['advertise_link'][$i]); ?>" type="text" name="advertise[advertise_link][]" />
                            </div>
		                    <div class="form_field">
		                        <input type="text" placeholder="Advertise file path" class="meta_image_url" name="advertise[image_url][]" value="<?php esc_html_e($advertise_data['image_url'][$i]); ?>"/>
		                    </div>
		                </div>
		                <div class="field_right image_wrap">
		                    <img src="<?php esc_html_e($advertise_data['image_url'][$i]); ?>" height="48" width="48" />
		                </div>
		                <div class="field_right">
		                    <input class="button" type="button" value="Choose File" onclick="add_image(this)" />
		                    <input class="button" type="button" value="Remove" onclick="remove_field(this)" />
		                </div>

		                <div class="clear" /></div> 
		        	</div>
		            <?php
		        }
		    }
	    ?>
    	</div>
	    <div style="display:none" id="master-row">
	        <div class="field_row">
	            <div class="field_left">
	            	<div class="form_field">
	                    <input class="meta_image_title" placeholder="Company name" value="" type="text" name="advertise[advertise_title][]" />
	                </div>
                    <div class="form_field">
                        <input class="meta_image_link" placeholder="Company website" value="" type="text" name="advertise[advertise_link][]" />
                    </div>
	                <div class="form_field">
	                    <input class="meta_image_url" placeholder="Advertise file path" value="" type="text" name="advertise[image_url][]" />
	                </div>
	            </div>
	            <div class="field_right image_wrap"></div> 
	            <div class="field_right"> 
	                <input type="button" class="button" value="Choose file" onclick="add_image(this)" />
	                <input class="button" type="button" value="Remove" onclick="remove_field(this)" /> 
	            </div>
	            <div class="clear"></div>
	        </div>
	    </div>
	    <div id="add_field_row">
	        <input class="button" type="button" value="Add Field" onclick="add_field_row();" />
	    </div>
    </div>
    <?php
}

/**
 * Print styles and scripts
 */
function advertise_print_scripts_so_14445904() {
    global $post;
    if ('advertise' != $post->post_type)
        return;
    ?>  
    <style type="text/css">
    	#post_advertise {
    		margin-top: -10px;
    	}
    	.image_wrap {
    		border: 1px solid #efefef;
		    padding: 5px;
		    margin-left: 15px;
		    margin-top: 0 !important;
		    width: 15%;
		    min-height: 100px;
    	}
    	.image_wrap img{
    		width: 100%;
    		height: auto;
    	}
    	.form_field {
    		margin-bottom: 10px;
    	}
        .field_left {
            float:left;
            width: 80%;
        }
        .field_right {
            float:left;
        }
        .clear {
            clear:both;
        }
        #dynamic_form {
            width:100%;
        }
        #dynamic_form input[type=text] {
            width: 100%;
		    box-shadow: none;
		    height: 30px;
        }
        #dynamic_form .field_row {
            border:1px solid #ddd;
            margin-bottom:10px;
            padding:10px;
        }
        #dynamic_form label {
            padding:0 6px;
        }
        .field_right .button, #add_field_row .button {
        	box-shadow: none !important;
        	border-radius: 0 !important;
        	width: 115px;
        }
    </style>
    <script type="text/javascript">

        function add_image(obj) {
            var parent = jQuery(obj).parent().parent('div.field_row');
            var inputField = jQuery(parent).find("input.meta_image_url");
            var fileFrame = wp.media.frames.file_frame = wp.media({
                multiple: false
            });
            fileFrame.on('select', function () {
                var url = fileFrame.state().get('selection').first().toJSON();
                inputField.val(url.url);
                jQuery(parent)
                        .find("div.image_wrap")
                        .html('<img src="' + url.url + '" height="48" width="48" />');
            });
            fileFrame.open();
        }
        ;
        function remove_field(obj) {
            var parent = jQuery(obj).parent().parent();
            //console.log(parent)
            parent.remove();
        }
        function add_field_row() {

            var row = jQuery('#master-row').html();
            jQuery(row).appendTo('#field_wrap');
        }
    </script>
    <?php
}
/**
 * Save post action, process fields
 */
function update_post_advertise_so_14445904($post_id, $post_object) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    if ('revision' == $post_object->post_type)
        return;
    if (!wp_verify_nonce($_POST['advertise_noncename_so_14445904'], plugin_basename(__FILE__)))
        return;
    if ('advertise' != $_POST['post_type']) // here you can set post type name
        return;
    if ($_POST['advertise']) {
     
        $advertise_data = array();
        for ($i = 0; $i < count($_POST['advertise']['image_url']); $i++) {
            if ('' != $_POST['advertise']['image_url'][$i]) {
            	$advertise_data['advertise_title'][] = $_POST['advertise']['advertise_title'][$i];
                $advertise_data['image_url'][] = $_POST['advertise']['image_url'][$i];
                $advertise_data['advertise_link'][] = $_POST['advertise']['advertise_link'][$i];
            }
        }
        if ($advertise_data)
            update_post_meta($post_id, 'advertise_data', $advertise_data);
        else
            delete_post_meta($post_id, 'advertise_data');
    }else {
        delete_post_meta($post_id, 'advertise_data');
    }
}
// remove yoast seo meta box in custom post type
function adv_remove_wp_seo_meta_box() {
    remove_meta_box('wpseo_meta', 'advertise', 'normal');
    remove_meta_box('postimagediv', 'advertise', 'side');
}
add_action('add_meta_boxes', 'adv_remove_wp_seo_meta_box', 100);