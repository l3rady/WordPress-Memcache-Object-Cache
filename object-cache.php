<?php
/*
Plugin Name: WordPress Memcache Object Cache Backend
Plugin URI: https://github.com/l3rady/WordPress-Memcache-Object-Cache
Description: Memcache backend for WordPress' Object Cache
Version: 1.0
Author: Scott Cariss
Author URI: http://l3rady.com
*/

/*  Copyright 2015  Scott Cariss  (email : scott@l3rady.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Stop direct access
defined( 'ABSPATH' ) or exit;


/**
 * Adds data to the cache, if the cache key does not already exist.
 *
 * @param int|string $key    The cache key to use for retrieval later
 * @param mixed      $data   The data to add to the cache store
 * @param string     $group  The group to add the cache to
 * @param int        $expire When the cache data should be expired
 *
 * @return bool False if cache key and group already exist, true on success
 */
function wp_cache_add( $key, $data, $group = 'default', $expire = 0 ) {
	return WP_Object_Cache::instance()->add( $key, $data, $group, $expire );
}


/**
 * Adds a group or set of groups to the list of global groups.
 *
 * @param string|array $groups A group or an array of groups to add
 */
function wp_cache_add_global_groups( $groups ) {
	WP_Object_Cache::instance()->add_global_groups( $groups );
}


/**
 * Adds a group or set of groups to the list of non-persistent groups.
 *
 * @param string|array $groups A group or an array of groups to add
 */
function wp_cache_add_non_persistent_groups( $groups ) {
	WP_Object_Cache::instance()->add_non_persistent_groups( $groups );
}


/**
 * Closes the cache.
 *
 * This function has ceased to do anything since WordPress 2.5. The
 * functionality was removed along with the rest of the persistent cache. This
 * does not mean that plugins can't implement this function when they need to
 * make sure that the cache is cleaned up after WordPress no longer needs it.
 *
 * @return bool Always returns True
 */
function wp_cache_close() {
	return true;
}


/**
 * Decrement numeric cache item's value
 *
 * @param int|string $key    The cache key to increment
 * @param int        $offset The amount by which to decrement the item's value. Default is 1.
 * @param string     $group  The group the key is in.
 *
 * @return false|int False on failure, the item's new value on success.
 */
function wp_cache_decr( $key, $offset = 1, $group = 'default' ) {
	return WP_Object_Cache::instance()->decr( $key, $offset, $group );
}


/**
 * Removes the cache contents matching key and group.
 *
 * @param int|string $key   What the contents in the cache are called
 * @param string     $group Where the cache contents are grouped
 *
 * @return bool True on successful removal, false on failure
 */
function wp_cache_delete( $key, $group = 'default' ) {
	return WP_Object_Cache::instance()->delete( $key, $group );
}


/**
 * Removes all cache items.
 *
 * @return bool False on failure, true on success
 */
function wp_cache_flush() {
	return WP_Object_Cache::instance()->flush();
}


/**
 * Invalidate a site's object cache
 *
 * @param mixed $sites Sites ID's that want flushing.
 *                     Don't pass a site to flush current site
 *
 * @return bool
 */
function wp_cache_flush_site( $sites = null ) {
	return WP_Object_Cache::instance()->flush_sites( $sites );
}


/**
 * Invalidate a groups object cache
 *
 * @param mixed $groups A group or an array of groups to invalidate
 *
 * @return bool
 */
function wp_cache_flush_group( $groups = 'default' ) {
	return WP_Object_Cache::instance()->flush_groups( $groups );
}


/**
 * Retrieves the cache contents from the cache by key and group.
 *
 * @param int|string $key    What the contents in the cache are called
 * @param string     $group  Where the cache contents are grouped
 * @param bool       $force  Forces a pull from memcache not local
 * @param bool       &$found Whether key was found in the cache. Disambiguates a return of false, a storable value.
 *
 * @return bool|mixed False on failure to retrieve contents or the cache contents on success
 */
function wp_cache_get( $key, $group = 'default', $force = false, &$found = null ) {
	return WP_Object_Cache::instance()->get( $key, $group, $force, $found );
}


/**
 * Retrieve multiple values from cache.
 *
 * Gets multiple values from cache, including across multiple groups
 *
 * Usage: array( 'group0' => array( 'key0', 'key1', 'key2', ), 'group1' => array( 'key0' ) )
 *
 * @param array $groups Array of groups and keys to retrieve
 *
 * @return array Array of cached values as
 *    array( 'group0' => array( 'key0' => 'value0', 'key1' => 'value1', 'key2' => 'value2', ) )
 *    Non-existent keys are not returned.
 */
function wp_cache_get_multi( $groups ) {
	return WP_Object_Cache::instance()->get_multi( $groups );
}


/**
 * Increment numeric cache item's value
 *
 * @param int|string $key    The cache key to increment
 * @param int        $offset The amount by which to increment the item's value. Default is 1.
 * @param string     $group  The group the key is in.
 *
 * @return false|int False on failure, the item's new value on success.
 */
function wp_cache_incr( $key, $offset = 1, $group = 'default' ) {
	return WP_Object_Cache::instance()->incr( $key, $offset, $group );
}


/**
 * Sets up Object Cache Global and assigns it.
 *
 * @global WP_Object_Cache $wp_object_cache WordPress Object Cache
 */
function wp_cache_init() {
	$GLOBALS['wp_object_cache'] = WP_Object_Cache::instance();
}


/**
 * Replaces the contents of the cache with new data.
 *
 * @param int|string $key    What to call the contents in the cache
 * @param mixed      $data   The contents to store in the cache
 * @param string     $group  Where to group the cache contents
 * @param int        $expire When to expire the cache contents
 *
 * @return bool False if not exists, true if contents were replaced
 */
function wp_cache_replace( $key, $data, $group = 'default', $expire = null ) {
	return WP_Object_Cache::instance()->replace( $key, $data, $group, $expire );
}


/**
 * Function was depreciated and now does nothing
 *
 * @return bool Always returns false
 */
function wp_cache_reset() {
	_deprecated_function( __FUNCTION__, '3.5', 'wp_cache_switch_to_blog()' );
	return false;
}


/**
 * Saves the data to the cache.
 *
 * @param int|string $key    What to call the contents in the cache
 * @param mixed      $data   The contents to store in the cache
 * @param string     $group  Where to group the cache contents
 * @param int        $expire When to expire the cache contents
 *
 * @return bool False on failure, true on success
 */
function wp_cache_set( $key, $data, $group = 'default', $expire = 0 ) {
	return WP_Object_Cache::instance()->set( $key, $data, $group, $expire );
}


/**
 * Switch the internal blog id.
 *
 * This changes the blog id used to create keys in blog specific groups.
 *
 * @param int $blog_id Blog ID
 */
function wp_cache_switch_to_blog( $blog_id ) {
	WP_Object_Cache::instance()->switch_to_blog( $blog_id );
}


/**
 * WordPress Memcache Object Cache Backend
 *
 * The WordPress Object Cache is used to save on trips to the database. The
 * Memcache Object Cache stores all of the cache data to Memcache and makes
 * the cache contents available by using a key, which is used to name and
 * later retrieve the cache contents.
 */
class WP_Object_Cache {
	/**
	 * @var int The sites current blog ID. This only
	 *    differs if running a multi-site installations
	 */
	private $blog_prefix = 1;


	/**
	 * @var int Keeps count of how many times the
	 *    cache was successfully received from cache
	 */
	private $cache_hits = 0;


	/**
	 * @var int Keeps count of how many times the
	 *    cache was not successfully received from cache
	 */
	private $cache_misses = 0;


	/**
	 * @var array Holds a list of cache groups that are
	 *    shared across all sites in a multi-site installation
	 */
	private $global_groups = array();


	/**
	 * @var array Holds an array of versions of the retrieved groups
	 */
	private $group_versions = array();


	/**
	 * @var Memcache
	 */
	private $mc = false;


	/**
	 * @var bool True if the current installation is a multi-site
	 */
	private $multi_site = false;


	/**
	 * @var array Holds cache that is to be non persistent
	 */
	private $non_persistent_cache = array();


	/**
	 * @var array Holds a list of cache groups that are not to be saved to cache
	 */
	private $non_persistent_groups = array();


	/**
	 * @var array Holds an array of versions of the retrieved sites
	 */
	private $site_versions = array();


	/**
	 * @var bool Have the group versions array been altered and need storing
	 */
	private $update_group_versions = false;


	/**
	 * @var bool Have the site versions array been altered and need storing
	 */
	private $update_site_versions = false;


	/**
	 * Singleton. Return instance of WP_Object_Cache
	 *
	 * @return WP_Object_Cache
	 */
	public static function instance() {
		static $inst = null;

		if ( $inst === null ) {
			$inst = new WP_Object_Cache();
		}

		return $inst;
	}


	/**
	 * __clone not allowed
	 */
	private function __clone() {
	}


	/**
	 * Direct access to __construct not allowed.
	 */
	private function __construct() {
		global $blog_id;

		if ( !defined( 'WP_MEMCACHE_KEY_SALT' ) ) {
			/**
			 * Set in config if you are using some sort of shared
			 * config where ABSPATH is the same on all sites
			 */
			define( 'WP_MEMCACHE_KEY_SALT', md5( ABSPATH ) );
		}

		// If not multisite then the blog id must be 1
		$this->multi_site  = is_multisite();
		$this->blog_prefix = $this->multi_site ? (int) $blog_id : 1;

		$this->_setup_memcache();
		$this->_get_site_versions();
		$this->_get_group_versions();

		register_shutdown_function( array( $this, 'shutdown' ) );
	}


	/**
	 * Setup the memcache connection
	 */
	private function _setup_memcache() {
		if ( !class_exists( 'Memcache' ) ) {
			return;
		}

		if ( !defined( 'WP_MEMCACHE_SERVERS' ) || !WP_MEMCACHE_SERVERS ) {
			define( 'WP_MEMCACHE_SERVERS', '127.0.0.1:11211:1' );
		}

		$servers = explode( '|', WP_MEMCACHE_SERVERS );

		$this->mc = new Memcache();

		foreach ( $servers as $server ) {
			$server = $this->_parse_memcache_server( $server );
			$this->mc->addserver( $server['address'], $server['port'], true, $server['weight'] );
		}
	}


	/**
	 * @param string $server Parse server to address/port/weight
	 *
	 * @return array
	 */
	private function _parse_memcache_server( $server ) {
		@list( $address, $port, $weight ) = explode( ':', $server );

		$address = $address ? $address : '127.0.0.1';
		$port    = $port ? intval( $port ) : intval( ini_get( 'memcache.default_port' ) );
		$port    = $port ? $port : 11211;
		$weight  = intval( $weight );
		$weight  = $weight ? $weight : 1;

		return array(
				'address' => $address,
				'port'    => $port,
				'weight'  => $weight
		);
	}


	/**
	 * Read out from memcache the current site versions
	 */
	private function _get_site_versions() {
		$this->site_versions = $this->_get( WP_MEMCACHE_KEY_SALT . ':site_versions' );

		if ( !is_array( $this->site_versions ) ) {
			$this->site_versions = array();
		}
	}


	/**
	 * Read out from memcache the current group versions
	 */
	private function _get_group_versions() {
		$this->group_versions = $this->_get( WP_MEMCACHE_KEY_SALT . ':0v' . $this->_get_site_version() . ':group_versions' );

		if ( !is_array( $this->group_versions ) ) {
			$this->group_versions = array();
		}
	}


	/**
	 * Get version for a given site
	 *
	 * @param int $site Site ID
	 *
	 * @return int Site version
	 */
	private function _get_site_version( $site = 0 ) {
		if ( isset( $this->site_versions[$site] ) ) {
			return $this->site_versions[$site];
		}

		$this->site_versions[$site] = 1;
		$this->update_site_versions = true;

		return 1;
	}


	/**
	 * Set version for a given site
	 *
	 * @param int $site    Site ID
	 * @param int $version Version
	 */
	private function _set_site_version( $site = 0, $version = 1 ) {
		$this->site_versions[$site] = $version;
		$this->update_site_versions = true;
	}


	/**
	 * Get version for a given group
	 *
	 * @param string $group Group name
	 *
	 * @return int Group version
	 */
	private function _get_group_version( $group = 'default' ) {
		if ( isset( $this->group_versions[$group] ) ) {
			return $this->group_versions[$group];
		}

		$this->group_versions[$group] = 1;
		$this->update_group_versions  = true;

		return 1;
	}


	/**
	 * Set version for a given group
	 *
	 * @param string $group   Group name
	 * @param int    $version Version
	 */
	private function _set_group_version( $group = 'default', $version = 1 ) {
		$this->group_versions[$group] = $version;
		$this->update_group_versions  = true;
	}


	/**
	 * Works out a cache key based on a given key and group
	 *
	 * @param string $key   The key
	 * @param string $group The group
	 *
	 * @return string Returns the calculated cache key
	 */
	private function _key( $key, $group ) {
		if ( empty( $group ) ) {
			$group = 'default';
		}

		$site = 0;

		if ( !isset( $this->global_groups[$group] ) ) {
			$site = $this->blog_prefix;
		}

		$site_version  = $this->_get_site_version( $site );
		$group_version = $this->_get_group_version( $group );

		return WP_MEMCACHE_KEY_SALT . ':'
		. $site . 'v' . $site_version . ':'
		. $group . 'v' . $group_version . ':'
		. $key;
	}


	/**
	 * Serializes (setting) or un-serializes (un-setting) $var
	 *
	 * We serialize all data going in and out of memcache so we don't
	 * have to do anything fancy with handling data types. Also we can
	 * correctly tell if a value is false or unset when getting from memcache
	 * as a false will be stored serialized. If we get false un-serialized
	 * then we know the value was not found.
	 *
	 * @param mixed     $var
	 * @param bool|true $setting
	 *
	 * @return mixed|string
	 */
	private function _parse_mc_var( $var, $setting = true ) {
		if ( $setting ) {
			return serialize( $var );
		}

		return unserialize( $var );
	}


	/**
	 * Memcache can only store to a max of 30 days. So do some parsing
	 * to make sure we don't pass that number
	 *
	 * @param int $ttl
	 *
	 * @return int|mixed
	 */
	private function _parse_mc_ttl( $ttl = 0 ) {
		$ttl = max( intval( $ttl ), 0 );
		$ttl = min( $ttl, 2592000 ); // TTL may not exceed 2592000 (30 days)

		return $ttl;
	}


	/**
	 * Checks if the cached key exists
	 *
	 * @param string $key What the contents in the cache are called
	 *
	 * @return bool True if cache key exists else false
	 */
	private function _exists( $key ) {
		return $this->mc->get( $key ) !== false;
	}


	/**
	 * Checks if the cached non persistent key exists
	 *
	 * @param string $key What the contents in the cache are called
	 *
	 * @return bool True if cache key exists else false
	 */
	private function _exists_np( $key ) {
		return isset( $this->non_persistent_cache[$key] );
	}


	/**
	 * Retrieves the cache contents, if it exists
	 *
	 * The contents will be first attempted to be retrieved by searching by the
	 * key in the cache key. If the cache is hit (success) then the contents
	 * are returned.
	 *
	 * On failure, the number of cache misses will be incremented.
	 *
	 * @param int|string $key   What the contents in the cache are called
	 * @param string     $group Where the cache contents are grouped
	 * @param bool       $force Forces a pull from memcache not local
	 * @param bool       &$found
	 *
	 * @return bool|mixed False on failure to retrieve contents or the cache contents on success
	 */
	public function get( $key, $group = 'default', $force = false, &$found = null ) {
		$key = $this->_key( $key, $group );

		if ( !$this->mc || $this->_is_non_persistent_group( $group ) ) {
			$var = $this->_get_np( $key, $found );
		}
		else {
			if ( !$force && $this->_exists_np( $key ) ) {
				$var = $this->_get_np( $key, $found );
			}
			else {
				$var = $this->_get( $key, $found );

				if ( $found ) {
					$this->_set_np( $key, $var );
				}
			}
		}

		if ( $found ) {
			$this->cache_hits++;
		}
		else {
			$this->cache_misses++;
		}

		return $var;
	}


	/**
	 * Retrieves the cache contents, if it exists
	 *
	 * @param string $key What the contents in the cache are called
	 * @param bool   &$found
	 *
	 * @return bool|mixed False on failure to retrieve contents or the cache contents on success
	 */
	private function _get( $key, &$found = null ) {
		$var   = $this->mc->get( $key, $found );
		$found = ( $var !== false );

		return $found ? $this->_parse_mc_var( $var, false ) : $found;
	}


	/**
	 * Retrieves the non persistent cache contents, if it exists
	 *
	 * @param string $key What the contents in the cache are called
	 * @param bool   &$found
	 *
	 * @return bool|mixed False on failure to retrieve contents or the cache contents on success
	 */
	private function _get_np( $key, &$found = null ) {
		if ( isset( $this->non_persistent_cache[$key] ) ) {
			$found = true;
			return $this->non_persistent_cache[$key];
		}

		return $found = false;
	}


	/**
	 * Retrieve multiple values from cache.
	 *
	 * Gets multiple values from cache, including across multiple groups
	 *
	 * Usage: array( 'group0' => array( 'key0', 'key1', 'key2', ), 'group1' => array( 'key0' ) )
	 *
	 * @param array $groups Array of groups and keys to retrieve
	 * @param bool  $force  Forces a pull from memcache not local
	 *
	 * @return array Array of cached values as
	 *    array( 'group0' => array( 'key0' => 'value0', 'key1' => 'value1', 'key2' => 'value2', ) )
	 *    Non-existent keys are not returned.
	 */
	public function get_multi( $groups, $force = false ) {
		if ( empty( $groups ) || !is_array( $groups ) ) {
			return false;
		}

		$vars  = array();
		$found = false;

		foreach ( $groups as $group => $keys ) {
			$vars[$group] = array();

			foreach ( $keys as $key ) {
				$var = $this->get( $key, $group, $force, $found );

				if ( $found ) {
					$vars[$group][$key] = $var;
				}
			}
		}

		return $vars;
	}


	/**
	 * Sets the data contents into the cache
	 *
	 * @param int|string $key   What to call the contents in the cache
	 * @param mixed      $var   The contents to store in the cache
	 * @param string     $group Where to group the cache contents
	 * @param int        $ttl   When the cache data should be expired
	 *
	 * @return bool True if cache set successfully else false
	 */
	public function set( $key, $var, $group = 'default', $ttl = 0 ) {
		$key = $this->_key( $key, $group );

		if ( !$this->mc || $this->_is_non_persistent_group( $group ) ) {
			return $this->_set_np( $key, $var );
		}

		$this->_set_np( $key, $var );
		return $this->_set( $key, $var, $ttl );
	}


	/**
	 * Sets the data contents into the cache
	 *
	 * @param string $key What to call the contents in the cache
	 * @param mixed  $var The contents to store in the cache
	 * @param int    $ttl When the cache data should be expired
	 *
	 * @return bool True if cache set successfully else false
	 */
	private function _set( $key, $var, $ttl ) {
		return $this->mc->set(
				$key,
				$this->_parse_mc_var( $var ),
				MEMCACHE_COMPRESSED,
				$this->_parse_mc_ttl( $ttl )
		);
	}


	/**
	 * Sets the data contents into the non persistent cache
	 *
	 * @param string $key What to call the contents in the cache
	 * @param mixed  $var The contents to store in the cache
	 *
	 * @return bool True if cache set successfully else false
	 */
	private function _set_np( $key, $var ) {
		if ( is_object( $var ) ) {
			$var = clone $var;
		}

		return $this->non_persistent_cache[$key] = $var;
	}


	/**
	 * Adds data to the cache, if the cache key does not already exist.
	 *
	 * @param int|string $key   The cache key to use for retrieval later
	 * @param mixed      $var   The data to add to the cache store
	 * @param string     $group The group to add the cache to
	 * @param int        $ttl   When the cache data should be expired
	 *
	 * @return bool False if cache key and group already exist, true on success
	 */
	public function add( $key, $var, $group = 'default', $ttl = 0 ) {
		if ( wp_suspend_cache_addition() ) {
			return false;
		}

		$key = $this->_key( $key, $group );

		if ( !$this->mc || $this->_is_non_persistent_group( $group ) ) {
			return $this->_add_np( $key, $var );
		}

		$this->_add_np( $key, $var );
		return $this->_add( $key, $var, $ttl );
	}


	/**
	 * Adds data to cache, if the cache key does not already exist.
	 *
	 * @param string $key The cache key to use for retrieval later
	 * @param mixed  $var The data to add to the cache store
	 * @param int    $ttl When the cache data should be expired
	 *
	 * @return bool False if cache key and group already exist, true on success
	 */
	private function _add( $key, $var, $ttl ) {
		if ( $this->_exists( $key ) ) {
			return false;
		}

		return $this->_set( $key, $var, $ttl );
	}


	/**
	 * Adds data to non persistent cache, if the cache key does not already exist.
	 *
	 * @param string $key The cache key to use for retrieval later
	 * @param mixed  $var The data to add to the cache store
	 *
	 * @return bool False if cache key and group already exist, true on success
	 */
	private function _add_np( $key, $var ) {
		if ( $this->_exists_np( $key ) ) {
			return false;
		}

		return $this->_set_np( $key, $var );
	}


	/**
	 * Remove the contents of the cache key in the group
	 *
	 * If the cache key does not exist in the group, then nothing will happen.
	 *
	 * @param int|string $key        What the contents in the cache are called
	 * @param string     $group      Where the cache contents are grouped
	 * @param bool       $deprecated Deprecated.
	 *
	 * @return bool False if the contents weren't deleted and true on success
	 */
	public function delete( $key, $group = 'default', $deprecated = false ) {
		unset( $deprecated );

		$key = $this->_key( $key, $group );

		if ( !$this->mc || $this->_is_non_persistent_group( $group ) ) {
			return $this->_delete_np( $key );
		}

		$this->_delete_np( $key );
		return $this->_delete( $key );
	}


	/**
	 * Remove the contents of the cache key in the group
	 *
	 * If the cache key does not exist in the group, then nothing will happen.
	 *
	 * @param string $key What the contents in the cache are called
	 *
	 * @return bool False if the contents weren't deleted and true on success
	 */
	private function _delete( $key ) {
		return $this->mc->delete( $key );
	}


	/**
	 * Remove the contents of the non persistent cache key in the group
	 *
	 * If the cache key does not exist in the group, then nothing will happen.
	 *
	 * @param string $key What the contents in the cache are called
	 *
	 * @return bool False if the contents weren't deleted and true on success
	 */
	private function _delete_np( $key ) {
		if ( isset( $this->non_persistent_cache[$key] ) ) {
			unset( $this->non_persistent_cache[$key] );

			return true;
		}

		return false;
	}


	/**
	 * Sets the list of global groups.
	 *
	 * @param string|array $groups List of groups that are global.
	 */
	public function add_global_groups( $groups ) {
		$groups = (array) $groups;

		$groups = array_fill_keys( $groups, true );

		$this->global_groups = array_merge( $this->global_groups, $groups );
	}


	/**
	 * Sets the list of non persistent groups.
	 *
	 * @param string|array $groups List of groups that are non persistent.
	 */
	public function add_non_persistent_groups( $groups ) {
		$groups = (array) $groups;

		$groups = array_fill_keys( $groups, true );

		$this->non_persistent_groups = array_merge(
				$this->non_persistent_groups,
				$groups
		);
	}


	/**
	 * Checks if the given group is a non persistent group
	 *
	 * @param string $group The group to be checked
	 *
	 * @return bool True if the group is a non persistent group else false
	 */
	private function _is_non_persistent_group( $group ) {
		return isset( $this->non_persistent_groups[$group] );
	}


	/**
	 * Replace the contents in the cache, if contents already exist
	 *
	 * @param int|string $key   What to call the contents in the cache
	 * @param mixed      $var   The contents to store in the cache
	 * @param string     $group Where to group the cache contents
	 * @param int        $ttl   When to expire the cache contents
	 *
	 * @return bool False if not exists, true if contents were replaced
	 */
	public function replace( $key, $var, $group = 'default', $ttl = null ) {
		$key = $this->_key( $key, $group );

		if ( !$this->mc || $this->_is_non_persistent_group( $group ) ) {
			return $this->_replace_np( $key, $var );
		}

		$this->_replace_np( $key, $var );
		return $this->_replace( $key, $var, $ttl );
	}


	/**
	 * Replace the contents in the cache, if contents already exist
	 *
	 * @param string $key What to call the contents in the cache
	 * @param mixed  $var The contents to store in the cache
	 * @param int    $ttl When to expire the cache contents
	 *
	 * @return bool False if not exists, true if contents were replaced
	 */
	private function _replace( $key, $var, $ttl ) {
		if ( !$this->_exists( $key ) ) {
			return false;
		}

		$ttl = isset( $ttl ) ? $this->_parse_mc_ttl( $ttl ) : null;

		return $this->mc->replace(
				$key,
				$this->_parse_mc_var( $var ),
				MEMCACHE_COMPRESSED,
				$ttl
		);
	}


	/**
	 * Replace the contents in the non persistent cache, if contents already exist
	 *
	 * @param string $key What to call the contents in the cache
	 * @param mixed  $var The contents to store in the cache
	 *
	 * @return bool False if not exists, true if contents were replaced
	 */
	private function _replace_np( $key, $var ) {
		if ( !$this->_exists_np( $key ) ) {
			return false;
		}

		return $this->_set_np( $key, $var );
	}


	/**
	 * Increment numeric cache item's value
	 *
	 * @param int|string $key    The cache key to increment
	 * @param int        $offset The amount by which to increment the item's value. Default is 1.
	 * @param string     $group  The group the key is in.
	 *
	 * @return false|int False on failure, the item's new value on success.
	 */
	public function incr( $key, $offset = 1, $group = 'default' ) {
		$key = $this->_key( $key, $group );

		if ( !$this->mc || $this->_is_non_persistent_group( $group ) ) {
			return $this->_incr_np( $key, $offset );
		}

		$this->_incr_np( $key, $offset );
		return $this->_incr( $key, $offset );
	}


	/**
	 * Increment numeric cache item's value
	 *
	 * @param string $key    The cache key to increment
	 * @param int    $offset The amount by which to increment the item's value. Default is 1.
	 *
	 * @return false|int False on failure, the item's new value on success.
	 */
	private function _incr( $key, $offset ) {
		$val = $this->_get( $key );

		if ( !is_int( $val ) ) {
			return false;
		}

		$offset = max( intval( $offset ), 0 );
		$val += $offset;

		$success = $this->mc->replace( $key, $this->_parse_mc_var( $val ) );

		return $success ? $val : false;
	}


	/**
	 * Increment numeric non persistent cache item's value
	 *
	 * @param string $key    The cache key to increment
	 * @param int    $offset The amount by which to increment the item's value. Default is 1.
	 *
	 * @return false|int False on failure, the item's new value on success.
	 */
	private function _incr_np( $key, $offset ) {
		if ( !$this->_exists_np( $key ) ) {
			return false;
		}

		$offset = max( intval( $offset ), 0 );
		$var    = $this->_get_np( $key );
		$var    = is_numeric( $var ) ? $var : 0;
		$var    = $var + $offset;

		return $this->_set_np( $key, $var );
	}


	/**
	 * Decrement numeric cache item's value
	 *
	 * @param int|string $key    The cache key to increment
	 * @param int        $offset The amount by which to decrement the item's value. Default is 1.
	 * @param string     $group  The group the key is in.
	 *
	 * @return false|int False on failure, the item's new value on success.
	 */
	public function decr( $key, $offset = 1, $group = 'default' ) {
		$key = $this->_key( $key, $group );

		if ( !$this->mc || $this->_is_non_persistent_group( $group ) ) {
			return $this->_decr_np( $key, $offset );
		}

		$this->_decr_np( $key, $offset );
		return $this->_decr( $key, $offset );
	}


	/**
	 * Decrement numeric cache item's value
	 *
	 * @param string $key    The cache key to increment
	 * @param int    $offset The amount by which to decrement the item's value. Default is 1.
	 *
	 * @return false|int False on failure, the item's new value on success.
	 */
	private function _decr( $key, $offset ) {
		$val = $this->_get( $key );

		if ( !is_int( $val ) ) {
			return false;
		}

		$offset = max( intval( $offset ), 0 );
		$val -= $offset;

		$success = $this->mc->replace( $key, $this->_parse_mc_var( $val ) );

		return $success ? $val : false;
	}


	/**
	 * Decrement numeric non persistent cache item's value
	 *
	 * @param string $key    The cache key to increment
	 * @param int    $offset The amount by which to decrement the item's value. Default is 1.
	 *
	 * @return false|int False on failure, the item's new value on success.
	 */
	private function _decr_np( $key, $offset ) {
		if ( !$this->_exists_np( $key ) ) {
			return false;
		}

		$offset = max( intval( $offset ), 0 );
		$var    = $this->_get_np( $key );
		$var    = is_numeric( $var ) ? $var : 0;
		$var    = $var - $offset;

		return $this->_set_np( $key, $var );
	}


	/**
	 * Clears the object cache of all data
	 *
	 * @return bool Always returns true
	 */
	public function flush() {
		$this->non_persistent_cache = array();

		if ( $this->mc ) {
			$this->mc->flush();
		}

		return true;
	}


	/**
	 * Invalidate a site's object cache
	 *
	 * @param mixed $sites Sites ID's that want flushing.
	 *                     Don't pass a site to flush current site
	 *
	 * @return bool
	 */
	public function flush_sites( $sites ) {
		$sites = (array) $sites;

		if ( empty( $sites ) ) {
			$sites = array( $this->blog_prefix );
		}

		// Add global groups (site 0) to be flushed.
		if ( !in_array( 0, $sites ) ) {
			$sites[] = 0;
		}

		foreach ( $sites as $site ) {
			$version = $this->_get_site_version( $site );
			$version++;
			$this->_set_site_version( $site, $version );
		}

		return true;
	}


	/**
	 * Invalidate a groups object cache
	 *
	 * @param mixed $groups A group or an array of groups to invalidate
	 *
	 * @return bool
	 */
	public function flush_groups( $groups ) {
		$groups = (array) $groups;

		if ( empty( $groups ) ) {
			return false;
		}

		foreach ( $groups as $group ) {
			$version = $this->_get_group_version( $group );
			$version++;
			$this->_set_group_version( $group, $version );
		}

		return true;
	}


	/**
	 * Switch the internal blog id.
	 *
	 * This changes the blog id used to create keys in blog specific groups.
	 *
	 * @param int $blog_id Blog ID
	 */
	public function switch_to_blog( $blog_id ) {
		$blog_id           = (int) $blog_id;
		$this->blog_prefix = $this->multi_site ? $blog_id : 1;
	}


	/**
	 * On script termination check if site/group version
	 * have changed and need saving out to memcache
	 */
	public function shutdown() {
		$this->_set_site_versions();
		$this->_set_group_versions();
	}


	/**
	 * Set group versions to memcache
	 */
	private function _set_group_versions() {
		if ( !$this->update_group_versions ) {
			return;
		}

		$this->_set( WP_MEMCACHE_KEY_SALT . ':0v' . $this->_get_site_version() . ':group_versions', $this->group_versions, 0 );
	}


	/**
	 * Set site versions to memcache
	 */
	private function _set_site_versions() {
		if ( !$this->update_site_versions ) {
			return;
		}

		$this->_set( WP_MEMCACHE_KEY_SALT . ':site_versions', $this->site_versions, 0 );
	}


	/**
	 * @return Memcache
	 */
	public function getMc() {
		return $this->mc;
	}


	/**
	 * @return int
	 */
	public function getBlogPrefix() {
		return $this->blog_prefix;
	}


	/**
	 * @return int
	 */
	public function getCacheHits() {
		return $this->cache_hits;
	}


	/**
	 * @return int
	 */
	public function getCacheMisses() {
		return $this->cache_misses;
	}


	/**
	 * @return array
	 */
	public function getGlobalGroups() {
		return $this->global_groups;
	}


	/**
	 * @return array
	 */
	public function getGroupVersions() {
		return $this->group_versions;
	}


	/**
	 * @return boolean
	 */
	public function isMultiSite() {
		return $this->multi_site;
	}


	/**
	 * @return array
	 */
	public function getNonPersistentCache() {
		return $this->non_persistent_cache;
	}


	/**
	 * @return array
	 */
	public function getNonPersistentGroups() {
		return $this->non_persistent_groups;
	}


	/**
	 * @return array
	 */
	public function getSiteVersions() {
		return $this->site_versions;
	}


	/**
	 * @return boolean
	 */
	public function isUpdateSiteVersions() {
		return $this->update_site_versions;
	}


	/**
	 * @return boolean
	 */
	public function isUpdateGroupVersions() {
		return $this->update_group_versions;
	}
}
