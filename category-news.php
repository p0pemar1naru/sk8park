<?php

    // calling the header.php
    get_header();

    // action hook for placing content above #container
    thematic_abovecontainer();

?>

		<div id="container">
		
			<?php thematic_abovecontent(); ?>
		
			<div id="content">
                
                <?php
                
                // show featured image above posts news loop
                if( function_exists('vslider') ) { ?>
                    <div id="news-top">
                        <?php vslider('newstop');
                } ?>
                    </div><!-- end: #news-top -->
                <?php
	        
	            // displays the page title
	            thematic_page_title();
	
	            // create the navigation above the content
	            thematic_navigation_above();
				
	            // action hook for placing content above the category loop
	            thematic_above_categoryloop();			
	
	            // action hook creating the category loop
	            thematic_categoryloop();
	
	            // action hook for placing content below the category loop
	            thematic_below_categoryloop();			
	
	            // create the navigation below the content
	            thematic_navigation_below();
	            
	            ?>
	
			</div><!-- #content -->
			
			<?php thematic_belowcontent(); ?> 
			
		</div><!-- #container -->

<?php 

    // action hook for placing content below #container
    thematic_belowcontainer();

    // calling the standard sidebar 
    thematic_sidebar();

    // calling footer.php
    get_footer();

?>