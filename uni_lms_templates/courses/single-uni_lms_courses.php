<?php
/**
 * The template for displaying all single course.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 */
get_header(); ?>
<div class="codoswp-container">
	<div class="row">
		<main id="primary" class="site-main col-sm-12 col-md-12">
        <?php while ( have_posts() ) : the_post(); ?>
            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <header class="page-header alignwide">
                    <div class="codoswp-container">
                        <div class="page-title">
                            <?php
                                the_title( '<h1>', '</h1>' );
                            ?>
                        </div>
                    </div>
                </header>
                <div class="entry-header">
                    <?php the_post_thumbnail() ?>
                    <?php if(get_post_meta( get_the_ID(), 'course_code', true )){ ?>
                        <strong><?php _e('Course Code:', 'unilms');?> </strong>
                        <?php echo esc_html( get_post_meta( get_the_ID(), 'course_code', true ) ); ?>
                        <br />
                    <?php } ?>
                    <?php if(get_post_meta( get_the_ID(), 'course_class', true )){ ?>
                        <strong><?php _e('Class:', 'unilms');?> </strong>
                        <a href="<?php echo get_permalink(get_post_meta( get_the_ID(), 'course_class', true ));?>" target="_blank">
                            <?php echo esc_html( get_the_title ( get_post_meta( get_the_ID(), 'course_class', true ) ) ); ?>
                        </a>
                        <br />
                    <?php } ?>
                    <?php if(get_post_meta( get_the_ID(), 'credit_hours', true )){ ?>
                        <strong><?php _e('Credit Hours:', 'unilms');?> </strong>
                        <?php echo esc_html( get_post_meta( get_the_ID(), 'credit_hours', true ) ); ?>
                        <br />
                    <?php } ?>
                    <?php if(get_post_meta( get_the_ID(), 'course_duration', true )){ ?>
                        <strong><?php _e('Course Duration (Weeks):', 'unilms');?> </strong>
                        <?php echo esc_html( get_post_meta( get_the_ID(), 'course_duration', true ) ); ?>
                        <br />
                    <?php } ?>
                    <?php if(get_post_meta( get_the_ID(), 'course_lectures_per_week', true )){ ?>
                        <strong><?php _e('Lectures Per Week:', 'unilms');?> </strong>
                        <?php echo esc_html( get_post_meta( get_the_ID(), 'course_lectures_per_week', true ) ); ?>
                    <?php } ?>
                </div><!-- .entry-header -->
                <div class="entry-content-wrapper">
                    <div class="entry-content">
                        <div class="uni_lms_course_tabs">
                            <button id="course-default-tab" class="tablinks" onclick="openCourseSections(event, 'course_overview')"><?php _e('Overview', 'unilms');?></button>
                            <button class="tablinks" onclick="openCourseSections(event, 'course_contents')"><?php _e('Contents', 'unilms');?></button>
                        </div>
                        <div id="course_overview" class="uni_lms_course_tabcontent">
                            <?php the_content(); ?>
                        </div>
                        <div id="course_contents" class="uni_lms_course_tabcontent">
                            <?php 
                                $repeatable_fields_unilms_coursecont = get_post_meta(get_the_ID(), 'repeatable_fields_unilms_coursecont', true);
                                if ( $repeatable_fields_unilms_coursecont ){
                                    $i = 1;
                                    foreach ( $repeatable_fields_unilms_coursecont as $field ) {
                                    ?>     
                                    <h5><?php _e('Day ', 'unilms'); echo '-'. $i; ?></h5> 
                                    <?php if(array_key_exists('unilms_coursecont_lecture', $field) && $field['unilms_coursecont_lecture'] != ''): ?>
                                    <strong><?php _e('Lecture: ', 'unilms');?></strong>
                                    <span><a href="<?php the_permalink($field['unilms_coursecont_lecture']); ?>"><?php echo esc_html(get_the_title($field['unilms_coursecont_lecture']));?></a></span><br>
                                    <?php endif;?>
                                    <?php if(array_key_exists('unilms_coursecont_assign', $field) && $field['unilms_coursecont_assign'] != ''): ?>
                                    <strong><?php _e('Assignment: ', 'unilms');?></strong>
                                    <span><a href="<?php the_permalink($field['unilms_coursecont_assign']); ?>"><?php echo esc_html(get_the_title($field['unilms_coursecont_assign']));?></a></span><br>
                                    <?php endif;?>
                                    <?php if(array_key_exists('unilms_coursecont_quiz', $field) && $field['unilms_coursecont_quiz'] != ''): ?>
                                    <strong><?php _e('Quiz: ', 'unilms');?></strong>
                                    <span><a href="<?php the_permalink($field['unilms_coursecont_quiz']); ?>"><?php echo esc_html(get_the_title($field['unilms_coursecont_quiz']));?></a></span><br>
                                    <?php endif;?>
                                    <br>
                            <?php
                                    $i++;
                                    }
                                }else{
                                    _e('No contents defined yet!: ', 'unilms');
                                }
                            ?>
                        </div>
                    </div><!-- .entry-content -->
                </div><!-- .entry-content-wrapper -->
            </article><!-- #post-## -->
            <?php
            // If comments are open or we have at least one comment, load up the comment template.
            if ( comments_open() || get_comments_number() ) :
                comments_template();
            endif;
            ?>
        <?php endwhile; // End of the loop. ?>

        </main><!-- #main -->
	</div><!-- .row -->
</div><!-- .codoswp-container -->
<?php
get_footer();
