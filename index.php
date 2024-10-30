<?php
/*
Plugin Name: Most Commented Posts
Plugin URI: http://blogwordpress.ws/plugin-most-commented-posts
Description: Plugin to show the image of most commented posts
Author: Anderson Makiyama
Version: 0.1
Author URI: http://blogwordpress.ws
*/


class Anderson_Makiyama_Most_Commented_Posts{
	const CLASS_NAME = 'Anderson_Makiyama_Most_Commented_Posts';
	public static $CLASS_NAME = self::CLASS_NAME;
	const PLUGIN_ID = 2;
	public static $PLUGIN_ID = self::PLUGIN_ID;
	const PLUGIN_NAME = 'Most Commented Posts';
	public static $PLUGIN_NAME = self::PLUGIN_NAME;
	const PLUGIN_PAGE = 'http://blogwordpress.ws/plugin-most-commented-posts';
	public static $PLUGIN_PAGE = self::PLUGIN_PAGE;
	const PLUGIN_VERSION = '0.1';
	public static $PLUGIN_VERSION = self::PLUGIN_VERSION;
	public $plugin_slug = "anderson_makiyama_";
	public $plugin_base_name;
	
    public function getStaticVar($var) {
        return self::$$var;
    }	
	
	public function __construct(){
		$this->plugin_base_name = plugin_basename(__FILE__);
		$this->plugin_slug.= str_replace(" ","_",self::PLUGIN_NAME);

	}
	
	public function init(){
		register_sidebar_widget(__('Most Commented Posts'), array(self::CLASS_NAME,'widget'));
		register_widget_control('Most Commented Posts', array(self::CLASS_NAME,'widget_options'));
		$css_file = plugins_url( 'styles/style.css', __FILE__ );

		wp_enqueue_style( self::CLASS_NAME, $css_file, false, '0.1' );
	}
	
	public function widget($args) {
		global $anderson_makiyama;
		
		extract($args);
		echo $before_widget;
        	$anderson_makiyama[self::PLUGIN_ID]->show_widget();
		echo $after_widget;
	}
	
	public function show_widget($how_many_directly=0){
		global $wpdb, $anderson_makiyama;
		$options = get_option($anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_options");
		
		
		echo "<h3>". $options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_title"] ."</h3>";
		echo $after_title;
        echo "<p>";
		echo "<ul id='most_commented_posts'>";

		$how_many = empty($options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_number"])?10:$options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_number"];
		if($how_many_directly !=0) $how_many = $how_many_directly;
		$period = empty($options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_period"])?'m':$options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_period"];
		$condicao = "";
		
		switch($period){
			case "w":
				$data = self::makeData(date("Y-m-d"), 0,0,-(date("w")));	//Condição >=
				$data = self::get_data_array($data);
				$condicao.= "YEAR(post_date) = ". $data["ano"] ." AND MONTH(post_date) = ". $data["mes"] . " AND DAY(post_date) >=" . $data["dia"];
			break;
			case "m":
				$condicao.= "YEAR(post_date) = YEAR(CURDATE()) AND MONTH(post_date) = MONTH(CURDATE())";
			break;
			default:
				$condicao.= "YEAR(post_date) = YEAR(CURDATE())";
		}
		
		$popular_posts = $wpdb->get_results("
		SELECT comment_count, ID, post_title
		FROM $wpdb->posts WHERE post_type='post' AND post_status = 'publish' AND $condicao
		ORDER BY comment_count DESC
		LIMIT $how_many
		");
		
		foreach($popular_posts as $post) {
			$url = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'thumbnail');
			if(empty($url[0])) $url[0] = get_bloginfo('siteurl') . '/wp-content/plugins/contextual-related-posts/default.png';
			echo "<li><a href='". get_permalink($post->ID) ."' title='". $post->post_title ."' ><img src='". $url[0] . "' alt='' title='". $post->post_title ."'/></a></li>"; 
			}
			echo '</ul></p>' . $after_widget;		
	}
	
	public function widget_options(){
		global $anderson_makiyama;
		global $user_level;
		get_currentuserinfo();
		if ($user_level < 10) {
			return;
		}
		
		$options = get_option($anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_options");
		
		if ($_POST[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug.'_submit']) {
			$options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug.'_title'] = htmlspecialchars($_POST[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug.'_title']);
			$options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug.'_number'] = htmlspecialchars($_POST[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug.'_number']);
			$options[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug.'_period'] = htmlspecialchars($_POST[$anderson_makiyama[self::PLUGIN_ID]->plugin_slug.'_period']);
			update_option($anderson_makiyama[self::PLUGIN_ID]->plugin_slug."_options", $options);
		}
		include("templates/widget.php");
	}	
	
	public static function makeData($data, $anoConta,$mesConta,$diaConta){
	   $ano = substr($data,0,4);
	   $mes = substr($data,5,2);
	   $dia = substr($data,8,2);
	   return date('Y-m-d',mktime (0, 0, 0, $mes+($mesConta), $dia+($diaConta), $ano+($anoConta)));	
	}
	
	public static function get_data_array($data,$part=''){
	   $data_ = array();
	   $data_["ano"] = substr($data,0,4);
	   $data_["mes"] = substr($data,5,2);
	   $data_["dia"] = substr($data,8,2);
	   if(empty($part))return $data_;
	   return $data_[$part];
	}	
	
	public static function isSelected($campo, $varCampo){
		if($campo==$varCampo) return " selected=selected ";
		return "";
	}	
}
if(!isset($anderson_makiyama)) $anderson_makiyama = array();
$anderson_makiyama_indice = Anderson_Makiyama_Most_Commented_Posts::PLUGIN_ID;

$anderson_makiyama[$anderson_makiyama_indice] = new Anderson_Makiyama_Most_Commented_Posts();

add_action("init", array($anderson_makiyama[$anderson_makiyama_indice]->getStaticVar('CLASS_NAME'), 'init'));
?>