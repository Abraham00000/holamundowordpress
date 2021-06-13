<?php

    function htinstagram_vc_maping() {

        vc_map(array(
            'base' => 'htinstagram',
            'name' => __( 'HT Instagram','ht-instagram'),
            'category' => __('HT Instagram','ht-instagram'),
            'params' => array(
                
                array(
                    'param_name' => 'limit',
                    'heading' => __( 'Item Limit', 'ht-instagram' ),
                    'type' => 'textfield',
                    'description' => __( 'Number of visible items', 'ht-instagram' ),
                    //'group'  => __( 'Styling', 'ht-instagram' ),
                ),

                array(
                  "param_name" => "column",
                  "heading" => __("Column", 'ht-instagram'),
                  "type" => "dropdown",
                  'value' => [
                      __( '4 Column', 'ht-instagram' )  =>  '4',
                      __( '1 Column', 'ht-instagram' )  =>  '1',
                      __( '2 Column', 'ht-instagram' )  =>  '2',
                      __( '3 Column', 'ht-instagram' )  =>  '3',
                      __( '5 Column', 'ht-instagram' )  =>  '5',
                      __( '6 Column', 'ht-instagram' )  =>  '6',
                  ],
                  'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    "param_name" => "showcaption",
                    "heading" => __("Show Caption", 'ht-instagram'),
                    "type" => "dropdown",
                    'value' => [
                        __( 'No', 'ht-instagram' )  =>  'no',
                        __( 'Yes', 'ht-instagram' )  =>  'yes',
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-4',
                ),

                array(
                    "param_name" => "caption_pos",
                    "heading" => __("Like Comment Position", 'ht-instagram'),
                    "type" => "dropdown",
                    "default_set" => 'top',
                    'value' => [
                        __( 'Top', 'ht-instagram' )  =>  'top',
                        __( 'Middle', 'ht-instagram' )  =>  'middle',
                        __( 'Bottom', 'ht-instagram' )  =>  'bottom',
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-4',
                ),

                array(
                    "param_name" => "showfollowbtn",
                    "heading" => __("Show Follow Button", 'ht-instagram'),
                    "type" => "dropdown",
                    'value' => [
                        __( 'Yes', 'ht-instagram' )  =>  'yes',
                        __( 'No', 'ht-instagram' )  =>  'no',
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-4',
                ),

                array(
                    "param_name" => "followbtnpos",
                    "heading" => __("Follow Button Position", 'ht-instagram'),
                    "type" => "dropdown",
                    "default_set" => 'bottom',
                    'value' => [
                        __( 'Top', 'ht-instagram' )  =>  'top',
                        __( 'Middle', 'ht-instagram' )  =>  'middle',
                        __( 'Bottom', 'ht-instagram' )  =>  'bottom',
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-4',
                ),

                array(
                    "param_name" => "target",
                    "heading" => __("Target", 'ht-instagram'),
                    "type" => "dropdown",
                    "default_set" => '_self',
                    'value' => [
                        __( 'Current window', 'ht-instagram' )  =>  '_self',
                        __( 'New window', 'ht-instagram' )  =>  '_blank',
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-4',
                ),

                array(
                    'param_name' => 'space',
                    'heading' => __( 'Gutter Space', 'ht-instagram' ),
                    'type' => 'textfield',
                    'description' => __( 'Item space Ex: 5', 'ht-instagram' ),
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    "param_name" => "slider_on",
                    "heading" => __("Slider Enable", 'ht-instagram'),
                    "type" => "dropdown",
                    'value' => [
                        __( 'No', 'ht-instagram' )  =>  'no',
                        __( 'Yes', 'ht-instagram' )  =>  'yes',
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'slitems',
                    'heading' => __( 'Slider Items', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'4',
                    'description' => __( 'Number of visible items', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                ),

                array(
                    'param_name' => 'slrows',
                    'heading' => __( 'Slider Row', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'2',
                    'description' => __( 'Number of visible slider row', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    "param_name" => "slarrows",
                    "heading" => __("Slider Arrow", 'ht-instagram'),
                    "type" => "dropdown",
                    'value' => [
                        __( 'No', 'ht-instagram' )  =>  'no',
                        __( 'Yes', 'ht-instagram' )  =>  'yes',
                    ],
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'slprevicon',
                    'heading' => __( 'Previous icon', 'ht-instagram' ),
                    'type' => 'iconpicker',
                    'value' => 'fa fa-angle-left',
                    'dependency' =>[
                        'element' => 'slarrows',
                        'value' => array( 'yes' ),
                    ],
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'slnexticon',
                    'heading' => __( 'Next icon', 'ht-instagram' ),
                    'type' => 'iconpicker',
                    'value' => 'fa fa-angle-right',
                    'dependency' =>[
                        'element' => 'slarrows',
                        'value' => array( 'yes' ),
                    ],
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    "param_name" => "sldots",
                    "heading" => __("Slider dots", 'ht-instagram'),
                    "type" => "dropdown",
                    'value' => [
                        __( 'No', 'ht-instagram' )  =>  'no',
                        __( 'Yes', 'ht-instagram' )  =>  'yes',
                    ],
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    "param_name" => "slcentermode",
                    "heading" => __("Center Mode", 'ht-instagram'),
                    "type" => "dropdown",
                    'value' => [
                        __( 'No', 'ht-instagram' )  =>  'no',
                        __( 'Yes', 'ht-instagram' )  =>  'yes',
                    ],
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'slcenterpadding',
                    'heading' => __( 'Center padding', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'0',
                    'description' => __( 'Center padding', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slcentermode',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    "param_name" => "slautolay",
                    "heading" => __("Auto Play", 'ht-instagram'),
                    "type" => "dropdown",
                    'value' => [
                        __( 'No', 'ht-instagram' )  =>  'no',
                        __( 'Yes', 'ht-instagram' )  =>  'yes',
                    ],
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'slautoplay_speed',
                    'heading' => __( 'Auto Play Speed', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'3000',
                    'description' => __( 'Auto Play Speed', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'slanimation_speed',
                    'heading' => __( 'Auto Play Speed', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'300',
                    'description' => __( 'Auto Play Animation Speed', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'slscroll_columns',
                    'heading' => __( 'Slider item to scroll', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'1',
                    'description' => __( 'Slider item to scroll', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'sltablet_width',
                    'heading' => __( 'Tablet Resolution', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'750',
                    'description' => __( 'The resolution to tablet.', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'sltablet_display_columns',
                    'heading' => __( 'Number of item on Tablet', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'1',
                    'description' => __( 'Number of item on Tablet', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'sltablet_scroll_columns',
                    'heading' => __( 'Slider item to scroll on tablet', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'1',
                    'description' => __( 'Slider item to scroll on tablet', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'slmobile_width',
                    'heading' => __( 'Mobile Resolution', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'480',
                    'description' => __( 'Mobile Resolution', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'slmobile_display_columns',
                    'heading' => __( 'Number of item on Mobile', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'1',
                    'description' => __( 'Number of item on Mobile', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'slmobile_scroll_columns',
                    'heading' => __( 'Slider item to scroll on mobile', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'1',
                    'description' => __( 'Slider item to scroll on mobile', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),

                array(
                    'param_name' => 'slmobile_scroll_columns',
                    'heading' => __( 'Slider item to scroll on mobile', 'ht-instagram' ),
                    'type' => 'textfield',
                    'value'=>'1',
                    'description' => __( 'Slider item to scroll on mobile', 'ht-instagram' ),
                    'group'  => __( 'Slider Options', 'ht-instagram' ),
                    'dependency' =>[
                        'element' => 'slider_on',
                        'value' => array( 'yes' ),
                    ],
                    'edit_field_class' => 'vc_column vc_col-sm-6',
                ),
                
                array(
                    'param_name' => 'captionbg',
                    'heading' => __( 'Caption Background', 'ht-instagram' ),
                    'type' => 'colorpicker',
                    'group'  => __( 'Styling', 'ht-instagram' ),
                ),

                array(
                    'param_name' => 'caption_color',
                    'heading' => __( 'Caption Color', 'ht-instagram' ),
                    'type' => 'colorpicker',
                    'group'  => __( 'Styling', 'ht-instagram' ),
                ),

                array(
                    'param_name' => 'caption_font_size',
                    'heading' => __( 'Caption Font Size', 'ht-instagram' ),
                    'type' => 'textfield',
                    'group'  => __( 'Styling', 'ht-instagram' ),
                ),

                array(
                    'param_name' => 'follow_background',
                    'heading' => __( 'Follow Button Background', 'ht-instagram' ),
                    'type' => 'colorpicker',
                    'group'  => __( 'Styling', 'ht-instagram' ),
                ),

                array(
                    'param_name' => 'follow_buttoncolor',
                    'heading' => __( 'Follow Button Color', 'ht-instagram' ),
                    'type' => 'colorpicker',
                    'group'  => __( 'Styling', 'ht-instagram' ),
                ),

                array(
                    'param_name' => 'follow_button_f_s',
                    'heading' => __( 'Follow Button Font Size', 'ht-instagram' ),
                    'type' => 'textfield',
                    'group'  => __( 'Styling', 'ht-instagram' ),
                ),

                array(
                    'param_name' => 'follow_icon_color',
                    'heading' => __( 'Follow Button Icon Color', 'ht-instagram' ),
                    'type' => 'colorpicker',
                    'group'  => __( 'Styling', 'ht-instagram' ),
                ),

                array(
                    'param_name' => 'follow_icon_background',
                    'heading' => __( 'Follow Button Icon Color Background', 'ht-instagram' ),
                    'type' => 'colorpicker',
                    'group'  => __( 'Styling', 'ht-instagram' ),
                ),


            )
            
        ));

   }
   add_action( 'init', 'htinstagram_vc_maping' );

?>