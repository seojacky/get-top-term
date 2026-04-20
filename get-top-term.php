<?php
/*
 * Plugin Name: Служебный: Get Top Term: Получить ID категории самого верхнего уровня
 * Description: Плагин позволяет получать ID категории текущего поста и сохраняет в get_top_term( )
 * Plugin URI:  https://github.com/seojacky/get-top-term
 * Author: @big_jacky
 * Author URI: https://t.me/big_jacky
 * Plugin URI: https://github.com/seojacky/get-top-term
 * GitHub Plugin URI: https://github.com/seojacky/get-top-term
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Version:     1.0
 */
 if (!defined('ABSPATH')) {
    header('HTTP/1.0 403 Forbidden');
    exit;
}
 
 /**
 * Получает термин верхнего уровня, для указанного или текущего поста в цикле
 * @param  string          $taxonomy      Название таксономии
 * @param  integer/object  [$post_id = 0] ID или объект поста
 * @return string/wp_error Объект термина или false
 */
 
 /* Объект $top_term содержит такие данные
WP_Term Object
(
	[term_id] => 562
	[name] => Записи
	[slug] => zapisi
	[term_group] => 0
	[term_taxonomy_id] => 582
	[taxonomy] => tax
	[description] => 
	[parent] => 0
	[count] => 1
)
*/
 
 
 
 function get_top_term( $taxonomy, $post_id = 0 ) {
	if( isset($post_id->ID) ) $post_id = $post_id->ID;
	if( ! $post_id )          $post_id = get_the_ID();

	$terms = get_the_terms( $post_id, $taxonomy );

	if( ! $terms || is_wp_error($terms) ) return $terms;

	// только первый
	$term = array_shift( $terms );

	// найдем ТОП
	$parent_id = $term->parent;
	while( $parent_id ){
		$term = get_term_by( 'id', $parent_id, $term->taxonomy );
		$parent_id = $term->parent;
	}

	return $term;
}
?>
