<?php 

function shortcode_parameter($param){
	ob_start();

    $advertise_data = get_post_meta($param['id'], 'advertise_data', true);
    if (isset($advertise_data['image_url'])) {
        for ($i = 0; $i < count($advertise_data['image_url']); $i++) {
            
            if($advertise_data['advertise_link'][$i]){
                ?>
                    <a target="_blank" href="<?php echo $advertise_data['advertise_link'][$i]; ?>">
                        <img style="margin-bottom:15px;" src="<?php echo $advertise_data['image_url'][$i]; ?>" />
                    </a>
                <?php

            }else{
                ?>
                    <img style="margin-bottom:15px;" src="<?php echo $advertise_data['image_url'][$i]; ?>" />
                <?php

            }
            
        }
    }
    
	return ob_get_clean();
}

?>