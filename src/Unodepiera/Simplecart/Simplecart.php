<?php

namespace Unodepiera\Simplecart;
use Unodepiera\Simplecart\Exceptions\SimplecartExceptions as Exception;

/**
 *
 * Laravel 4 Simplecart package
 * @version 1.0.0
 * @copyright Copyright (c) 2013 Unodepiera
 * @author Israel Parra
 * @contact unodepiera@uno-de-piera.com
 * @link http://www.uno-de-piera.com
 * @date 2013-03-27
 * @license http://www.opensource.org/licenses/mit-license.php The MIT License
 *
 */

class Simplecart{


	/**
	* Content cart
	* @var array
	*/
	private $upd_cart = array();

	public function __construct()
	{
		//if not isset the cart create session cart and asign to cart_contents
		if(!isset($_SESSION["cart_udp"]))
		{
			$_SESSION["cart_udp"] = $this->upd_cart;
			$this->upd_cart["total_cart"] = 0;
			$this->upd_cart["total_articles"] = 0;
		}
		$this->upd_cart = $_SESSION['cart_udp'];
	}

	/**
	* Insert a product into cart.
	* @access public  
	* @param  array   	$items
	* @param  boolean   $update -->check if is a insert or update, default insert
	*/
	public function insert($items = array(), $update = false)
	{
		//required fields for create cart
		if(!isset($items["id"]) || !isset($items["qty"]) || !isset($items["price"]))
		{
			throw new Exception("Id, qty and price are required fields!.", 1);
		}

		//Id, qty and price need to be numeric type fields
		if(!is_numeric($items["id"]) || !is_numeric($items["qty"]) || !is_numeric($items["price"]))
		{
			throw new Exception("Id, qty and price must be numbers.", 1);
		}

		//items must be an array
		if(!is_array($items) || empty($items))
		{
			throw new Exception("The last row insert method must be an array", 1);	
		}

		$rowid = $this->_insert($items, $update);

		if($rowid)
		{
			$this->save_cart();
		}else{
			throw new Exception("Error saving cart", 1);	
		}

	}

	/**
	* Return rowid.
	* @access private 
	* @param  array   	$items
	* @param  boolean   $update -->check if is a insert or update, default insert
	* @return string
	*/
	private function _insert($items = array(), $update = false)
	{

	    //check if product has options
	    if (isset($items['options']))
		{

			$rowid = md5($items['id'].implode('', $items['options'])); 

		}else{

			$rowid = md5($items["id"]);

		}

		$items["rowid"] = $rowid;

		//if not empty cart
        if(!empty($this->upd_cart))
        {

        	//loop the cart contents
	        foreach($this->upd_cart as $row)
	        {
	        	//if this product exists in the cart update !
	        	if($row["rowid"] == $rowid && $update == false)
	        	{
	        		$items["qty"] = $row["qty"] + $items["qty"];
	        	}
	        }

	    }

	    $items["total"] = $items["qty"] * $items["price"];

		$this->_unset_row($rowid);

		$_SESSION['cart_udp'][$rowid] = $items;

		$this->get_cart();

		return $rowid;
		
	}

	/**
	* Remove row from cart by rowid key.
	* @param  string   	$rowid
	* @access private 
	*/
	private function _unset_row($rowid)
	{
		unset($_SESSION["cart_udp"][$rowid]);
	}

	/**
	* Return rowid.
	* @access private 
	* @return string
	*/
	private function save_cart()
	{
		$total = 0;
		$items = 0;

		foreach ($this->upd_cart as $row) 
		{
			$total += ($row['price'] * $row['qty']);
			$items += $row['qty'];
		}

		$_SESSION['cart_udp']["total_articles"] = $items;
		$_SESSION['cart_udp']["total_cart"] = $total;
		$this->get_cart();

	}

	/**
	* Return total money cart.
	* @access public 
	* @return float
	*/
	public function total_cart()
	{
		if(!is_numeric($this->upd_cart["total_cart"]))
		{
			return 0;
		}
		//check if total cart not is numeric and the cart not is null
		if(!is_numeric($this->upd_cart["total_cart"]))
		{
			throw new Exception("The total cart must be an numbers", 1);	
		}
		return $this->upd_cart["total_cart"] ? $this->upd_cart["total_cart"] : 0;
	}

	/**
	* Return total articles cart.
	* @access public 
	* @return int
	*/
	public function total_articles()
	{

		if(!is_numeric($this->upd_cart["total_articles"]))
		{
			return 0;
		}
		//check if total articles not is numeric and the cart not is null
		if(!is_numeric($this->upd_cart["total_articles"]))
		{
			throw new Exception("The total articles must be an numbers", 1);	
		}
		return $this->upd_cart["total_articles"] ? $this->upd_cart["total_articles"] : 0;
	}

	/**
	* Return content cart or null if cart is empty
	* @access public 
	* @return array or null
	*/
	public function get_content()
	{
		$cart = $this->upd_cart;
		unset($cart["total_articles"]);
		unset($cart["total_cart"]);
		return $cart == null ? null : $cart;
	}

	/**
	* Update row from cart by rowid
	* @access public 
	* @param array 		$item
	* @return array or null
	*/
	public function update($item = array())
	{

		//if not exists cart
		if($this->upd_cart === null)
		{
			throw new Exception("Cart does not exist!", 1);
		}

		//check if product has options
	    if (isset($item['options']))
		{

			$rowid = md5($item['id'].implode('', $item['options'])); 

		}else{

			$rowid = md5($item["id"]);

		}

		//if not exists rowid into cart
		if(!isset($this->upd_cart[$rowid]))
		{
			throw new Exception("The rowid $rowid does not exist!", 1);
		}

		//if item rowid not equals rowid cart
		if($rowid !== $this->upd_cart[$rowid]["rowid"])
		{
			throw new Exception("Can not update the options!", 1);
		}

		$this->insert($item, true);
		
	}

	/**
	* Remove row from cart.
	* @access public
	* @param string 	$rowid 
	*/
	public function remove_item($rowid)
	{

		//if not exists cart
		if($this->upd_cart === null)
		{
			throw new Exception("Cart does not exist!", 1);
		}

		if(!isset($this->upd_cart[$rowid]))
		{
			throw new Exception("The rowid $rowid does not exist!", 1);
		}

		$this->_remove_item($rowid);

	}

	/**
	* Remove row from cart.
	* @access private 
	* @param string 	$rowid 
	*/
	private function _remove_item($rowid)
	{
		$this->_unset_row($rowid);
		$this->get_cart();
	}

	/**
	* Return cart.
	* @access private 
	* @return array
	*/
	private function get_cart()
	{
		return self::__construct();
	}

	/**
	* Destroy cart.
	* @access private  
	*/
	private function _destroy()
	{
		unset($_SESSION["cart_udp"]);
		$this->upd_cart = null;
	}

	/**
	* Destroy cart.
	* @access public  
	*/
	public function destroy()
	{
		$this->_destroy();
	}
}