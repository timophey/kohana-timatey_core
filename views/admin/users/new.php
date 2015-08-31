<?php defined('SYSPATH') or die('No direct script access.');
 
/**
 * @var array           $config       Global blog configuration
 * @var Model_User      $user         Global Kohana user object
 * @var string          $message      Global message
 * @var string          $message_type Global message type string
 * @var array           $item         Current item data
 * @var Database_Result $roles        All roles list
 *
 * @author     Novichkov Sergey(Radik) <novichkovsergey@yandex.ru>
 * @copyright  Copyrights (c) 2012 Novichkov Sergey
 */
?>

 
<div id="container">
    <div id="content" class="container">
        <div class="row title">
            <div class="span12">
                <h1 class="pull-left"><?php echo __('New user') ?></h1>
            </div>
    </div>
 
         <?php echo View::factory('admin/users/form', array('item' => $item, 'roles' => $roles)) ?>
    </div>
</div>
 
