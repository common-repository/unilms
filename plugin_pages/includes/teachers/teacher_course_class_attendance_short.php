<?php
if(isset($student_reg_no) && $student_reg_no != ""){
	$args = array( 
		'post_type' => 'uni_lms_students',
		'posts_per_page' => -1,
		'meta_query' => array(
			'relation' => 'AND',
		    array(
                'key' => 'student_class',
                'value' => $class_id,
                'compare' => '=',
                'type' => 'CHAR'       
            ),
            array(
                'key' => 'student_reg_no',
                'value' => $student_reg_no,
                'compare' => '=',
                'type' => 'CHAR'       
            )
		)
	);
}else{
	$args = array( 
		'post_type' => 'uni_lms_students',
		'posts_per_page' => -1,
        'meta_key' => 'student_reg_no',
        'orderby' => 'meta_value',
        'order' => 'ASC',
		'meta_query' => array(
		    array(
                'key' => 'student_class',
                'value' => $class_id,
                'compare' => '=',
                'type' => 'CHAR'       
            )
		)
	);
}

	$loop = new WP_Query( $args );

	$attendance_args = array( 
		'post_type' => 'uni_lms_attendances',
		'posts_per_page' => -1,
		'order' => 'ASC',
		'meta_query' => array(
			'relation' => 'AND',
		    array(
                'key' => 'attendance_class',
                'value' => $class_id,
                'compare' => '=',
                'type' => 'CHAR'       
            ),
            array(
                'key' => 'attendance_course',
                'value' => $course_id,
                'compare' => '=',
                'type' => 'CHAR'       
            )
		)
	);
	$inner_query = new WP_Query($attendance_args);
	$total_attendances = $inner_query->found_posts;

	?>
	<style>
.widefat td, .widefat th {
    border: 1px solid #000;
}
</style>
	<table class="widefat">
	    <thead>
			<tr><td colspan="200" style="text-align: center;"><?php _e('Short Attendance Record (Attendance less than 75%)', 'unilms-pro');?></td></tr>
		    <tr>
		        <th><strong><?php _e('Student', 'unilms-pro');?></strong></th>
				<th><strong><?php _e('Total', 'unilms-pro');?></strong></th>
		        <th><strong><?php _e('Percentage', 'unilms-pro');?></strong></th>
		    </tr>
		</thead>
		<tbody>
	<?php
	if($loop->have_posts()){

		while ($loop->have_posts()) : $loop->the_post();
			$student_id = get_the_ID();
			$presents = 0;
	?>
			<tr>
	<?php
		    	while ($inner_query->have_posts()) : $inner_query->the_post();
		        	$attendance_id = get_the_ID();
		        	$student_attendance = get_post_meta( $attendance_id , 'uni_lms_attendance_student-'.$student_id, true );
		        	if($student_attendance == 'yes'){
		        		$presents += 1;
		        	}
		        	
		    	endwhile;
				if(($presents/$total_attendances)*100 < 75){
	?>
				    <td><?php echo get_the_title($student_id);?></td>
					<td><?php echo esc_html($presents) . '/' . esc_html($total_attendances); ?></td>
				    <td><?php echo ($presents/$total_attendances)*100;?></td>
				<?php 
				}?>
		</tr>
	<?php
		endwhile;

	}else{
	?>
			<tr><td colspan="16"><?php _e('Sorry no data to show', 'unilms-pro');?></td></tr>
	<?php
	}
	?>
		</tbody>
	</table>
	<?php //global $wp_query;
// }else{
// 	echo 'Cannot access this page directlty';
// }
?>