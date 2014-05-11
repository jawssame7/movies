<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

    public $useragents = [
        'iPhone',   // Apple iPhone
        'iPod',     // Apple iPod touch
        'Android'   // Android
    ];

    public function beforeRender() {

        $pattern = '/'.implode('|', $this->useragents).'/i';

        if($_ua = preg_match($pattern, $_SERVER['HTTP_USER_AGENT'])){
            $this->set('userAgent', 'sp');
        }else{
            $this->set('userAgent', 'pc');
        }
    }

    /**
     * json形式にパースして、json用のviewをレンダリング
     * @param $result
     */
    protected function renderJsonView($result) {

        $item = json_encode($result);

        $this->set('item', $item);

        $this->set('_serialize', array('item'));

        if (Configure::read('debug') < 2) {
            $this->RequestHandler->respondAs('application/json; charset=UTF-8');
        } else {
            $this->layout = 'ajax';
        }

        $this->render('/Json/default');

    }

}
