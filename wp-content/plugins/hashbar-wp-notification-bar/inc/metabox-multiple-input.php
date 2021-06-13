<?php 
	/**
	 * CMB2 Multiple Custom input Field Type
	*/

	function hashbar_wpnb_contetn_margin( $field, $value, $object_id, $object_type, $field_type ) {
	$value = wp_parse_args( $value, array(
	    'margin_top' => '',
	    'margin_right' => '',
	    'margin_bottom'  => '',
	    'margin_left'  => '',
	) );
	?>
	<div class="alignleft" style="width: 60px;margin-right:10px;">
	    <?php echo $field_type->input( array(
	        'class' => 'cmb_text_small',
	        'name'  => $field_type->_name( '[margin_top]' ),
	        'id'    => $field_type->_id( '_margin_top' ),
	        'type'  => 'text',
	        'default' => '0px',
	        'value' => $value['margin_top']
	    ) ); ?>
	</div>
	<div class="alignleft" style="width: 60px;margin-right:10px;">
	    <?php echo $field_type->input( array(
	        'class' => 'cmb_text_small',
	        'name'  => $field_type->_name( '[margin_right]' ),
	        'id'    => $field_type->_id( '_margin_right' ),
	        'type'  => 'text',
	        'value' => $value['margin_right'],
	    ) ); ?>
	</div>
	<div class="alignleft" style="width: 60px;margin-right:10px;">
	    <?php echo $field_type->input( array(
	        'class' => 'cmb_text_small',
	        'name'  => $field_type->_name( '[margin_bottom]' ),
	        'id'    => $field_type->_id( '_margin_bottom' ),
	        'type'  => 'text',
	        'value' => $value['margin_bottom'],
	    ) ); ?>
	</div>
	<div class="alignleft" style="width: 60px;margin-right:10px;">
	    <?php echo $field_type->input( array(
	        'class' => 'cmb_text_small',
	        'name'  => $field_type->_name( '[margin_left]' ),
	        'id'    => $field_type->_id( '_margin_left' ),
	        'type'  => 'text',
	        'value' => $value['margin_left'],
	    ) ); ?>
	</div>
	<div class="clear"></div>
	<p style="display: block;"><?php echo esc_html__('Give margin top, right, bottom, left of contnt. Use unit px. Sample: 5px 5px 5px 5px','hashbar') ?></p>
	<?php
	}

	add_filter( 'cmb2_render_hashbar_margin_input', 'hashbar_wpnb_contetn_margin', 10, 5 );

	function hashbar_wpnb_contetn_padding( $field, $value, $object_id, $object_type, $field_type ) {
	$value = wp_parse_args( $value, array(
	    'padding_top' => '',
	    'padding_right' => '',
	    'padding_bottom'  => '',
	    'padding_left'  => '',
	) );
	?>
	<div class="alignleft" style="width: 60px;margin-right:10px;">
	    <?php echo $field_type->input( array(
	        'class'   => 'cmb_text_small',
	        'name'    => $field_type->_name( '[padding_top]' ),
	        'id'      => $field_type->_id( '_padding_top' ),
	        'type'    => 'text',
	        'value'   => $value['padding_top']
	    ) ); ?>
	</div>
	<div class="alignleft" style="width: 60px;margin-right:10px;">
	    <?php echo $field_type->input( array(
	        'class' => 'cmb_text_small',
	        'name'  => $field_type->_name( '[padding_right]' ),
	        'id'    => $field_type->_id( '_padding_right' ),
	        'type'  => 'text',
	        'value' => $value['padding_right'],
	    ) ); ?>
	</div>
	<div class="alignleft" style="width: 60px;margin-right:10px;">
	    <?php echo $field_type->input( array(
	        'class' => 'cmb_text_small',
	        'name'  => $field_type->_name( '[padding_bottom]' ),
	        'id'    => $field_type->_id( '_padding_bottom' ),
	        'type'  => 'text',
	        'value' => $value['padding_bottom'],
	    ) ); ?>
	</div>
	<div class="alignleft" style="width: 60px;margin-right:10px;">
	    <?php echo $field_type->input( array(
	        'class' => 'cmb_text_small',
	        'name'  => $field_type->_name( '[padding_left]' ),
	        'id'    => $field_type->_id( '_padding_left' ),
	        'type'  => 'text',
	        'value' => $value['padding_left'],
	    ) ); ?>
	</div>
	<div class="clear"></div>
	<p style="display: block;"><?php echo esc_html__('Give padding top, right, bottom, left of contnt. Use unit px. Sample: 5px 5px 5px 5px','hashbar') ?></p>
	<?php
	}

	add_filter( 'cmb2_render_hashbar_padding_inpupt', 'hashbar_wpnb_contetn_padding', 10, 5 );

?>