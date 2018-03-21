<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

/**
 * The default class to use for all routes
 *
 * The following route classes are supplied with CakePHP and are appropriate
 * to set as the default:
 *
 * - Route
 * - InflectedRoute
 * - DashedRoute
 *
 * If no call is made to `Router::defaultRouteClass()`, the class used is
 * `Route` (`Cake\Routing\Route\Route`)
 *
 * Note that `Route` does not do any inflections on URLs which will result in
 * inconsistently cased URLs when used with `:plugin`, `:controller` and
 * `:action` markers.
 *
 */
    Router::defaultRouteClass(DashedRoute::class);

// for prefix admin
/*Router::prefix('admin', function ($routes) {
    // All routes here will be prefixed with `/admin`
    // And have the prefix => admin route element added.
    //login
    $routes->connect('/', ['controller' => 'Users', 'action' => 'login']);

    $routes->fallbacks('InflectedRoute');
});*/

// for non prefix admin
Router::scope('/', function (RouteBuilder $routes) {
    /**
     * Here, we are connecting '/' (base path) to a controller called 'Pages',
     * its action called 'display', and we pass a param to select the view file
     * to use (in this case, src/Template/Pages/home.ctp)...
     */

    $routes->connect('/admin', ['plugin' => 'Admin', 'controller' => 'admin-details', 'action' => 'login']);
	$routes->connect('/', ['controller' => 'Sites', 'action' => 'home-page']);
	$routes->connect('/index', ['controller' => 'Sites', 'action' => 'home-page']);
	$routes->connect('/most-viewed', ['controller' => 'Sites', 'action' => 'most-viewed']);
	$routes->connect('/un-answered', ['controller' => 'Sites', 'action' => 'un-answered']);
	$routes->connect('/post-question', ['controller' => 'Questions', 'action' => 'postQuestion']);
	$routes->connect('/questions', ['controller' => 'Questions', 'action' => 'all-questions']);
	$routes->connect('/most-viewed-questions', ['controller' => 'Questions', 'action' => 'most-viewed-questions']);
	$routes->connect('/un-answered-questions', ['controller' => 'Questions', 'action' => 'un-answered-questions']);	
	$routes->connect('/category/*', ['controller' => 'Questions', 'action' => 'question-category']);
	$routes->connect('/tag/*', ['controller' => 'Questions', 'action' => 'question-tag']);
	$routes->connect('/users', ['controller' => 'Users', 'action' => 'all-users']);
	$routes->connect('/news', ['controller' => 'News', 'action' => 'news-listing']);
	$routes->connect('/news/details', ['controller' => 'News', 'action' => 'details']);
	$routes->connect('/about-us', ['controller' => 'Sites', 'action' => 'aboutUs']);
	$routes->connect('/contact-us', ['controller' => 'Sites', 'action' => 'contactUs']);
	$routes->connect('/terms-of-use', ['controller' => 'Sites', 'action' => 'termsAndConditions']);
	$routes->connect('/privacy', ['controller' => 'Sites', 'action' => 'privacy']);
	$routes->connect('/faqs', ['controller' => 'Sites', 'action' => 'faqs']);
	$routes->connect('/signup', ['controller' => 'Users', 'action' => 'signup']);
	$routes->connect('/login', ['controller' => 'Users', 'action' => 'login']);
	$routes->connect('/logout', ['controller' => 'Users', 'action' => 'logout']);
	$routes->connect('/my-account', ['controller' => 'Users', 'action' => 'my-account']);
	$routes->connect('/account-setting', ['controller' => 'Users', 'action' => 'account-setting']);
	$routes->connect('/edit-profile', ['controller' => 'Users', 'action' => 'edit-profile']);
	$routes->connect('/change-password', ['controller' => 'Users', 'action' => 'change-password']);
	$routes->connect('/forgot-password', ['controller' => 'Users', 'action' => 'forgot-password']);	
	$routes->connect('/view-submissions', ['controller' => 'Users', 'action' => 'view-submissions']);
	$routes->connect('/edit-submitted-question/*', ['controller' => 'Questions', 'action' => 'edit-submitted-question']);
	$routes->connect('/edit-submitted-question-comment/*', ['controller' => 'Questions', 'action' => 'edit-submitted-question-comment']);
	$routes->connect('/edit-submitted-question-answer/*', ['controller' => 'Questions', 'action' => 'edit-submitted-question-answer']);
	$routes->connect('/edit-submitted-question-answer-comment/*', ['controller' => 'Questions', 'action' => 'edit-submitted-question-answer-comment']);
	$routes->connect('/edit-submitted-news-comment/*', ['controller' => 'News', 'action' => 'edit-submitted-news-comment']);

    /*
    /**
     * Connect catchall routes for all controllers.
     *
     * Using the argument `DashedRoute`, the `fallbacks` method is a shortcut for
     *    `$routes->connect('/:controller', ['action' => 'index'], ['routeClass' => 'DashedRoute']);`
     *    `$routes->connect('/:controller/:action/*', [], ['routeClass' => 'DashedRoute']);`
     *
     * Any route class can be used with this method, such as:
     * - DashedRoute
     * - InflectedRoute
     * - Route
     * - Or your own route class
     *
     * You can remove these routes once you've connected the
     * routes you want in your application.
     */
    $routes->fallbacks('DashedRoute');
});

/**
 * Load all plugin routes.  See the Plugin documentation on
 * how to customize the loading of plugin routes.
 */
Plugin::routes();
