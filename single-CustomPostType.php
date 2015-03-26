<?php
 /*Template Name: Cake Template  
 */
  
get_header(); ?>
<div id="primary">
    <div id="content" role="main">
    <?php
    $mypost = array( 'post_type' => 'cake', );
	// retrives all the posts from database	
    $loop = new WP_Query( 'post_type=cake' );
    ?>
    <?php while ( $loop->have_posts() ) : $loop->the_post();?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?> style="position:relative;width:100%;">
            <header class="entry-header">
 
                <!-- Display featured image in right-aligned floating div -->
				<br /> <br />
                <div style="float: right; margin: 10px">
                    <?php the_post_thumbnail( array( 100, 100 ) ); ?>
                </div>
 
                <!-- Display Cake Flavor, Author Name and Recipe -->
                <strong>Cake: </strong> <?php echo esc_html( get_post_meta( get_the_ID(), '_cake_flavor', true ) ); ?><br />
                <strong>Author: </strong>
                <?php echo esc_html( get_post_meta( get_the_ID(), '_cake_author', true ) ); ?>
                <br />
                <strong>Recipe: </strong>
                <?php
                echo get_post_meta( get_the_ID(), '_cake_recipe', true );
                ?>
            </header>
 

        </article>
 
    <?php endwhile; ?>
    </div>
</div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>