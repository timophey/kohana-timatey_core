<?php defined('SYSPATH') or die('No direct script access.');
 
/**
 * @var array           $config       Global blog configuration
 * @var Model_User      $user         Global Kohana user object
 * @var string          $message      Global message
 * @var string          $message_type Global message type string
 * @var Database_Result $items        Users list
 * @var Pagination      $pagination   Pagination object
 *
 * @author     Novichkov Sergey(Radik) <novichkovsergey@yandex.ru>
 * @copyright  Copyrights (c) 2012 Novichkov Sergey
 */
?>
 
<div id="container">
    <div id="content">
        <div>
            <div>
                <h1><?php echo __('Users list') ?></h1>
                <a
                   href="<?php echo URL::site('/admin/users/new') ?>"><i></i> <?php echo __('New') ?></a>
            </div>
        </div>
 
        <?php if (isset($message)) : ?>
            <div>
                <div>
                    <div>
                        <a href="#" data-dismiss="alert">×</a>
                        <?php echo $message ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
 
        <div>
            <div>
                <table>
                    <thead>
                    <tr>
                        <th><?php echo __('ID') ?></th>
                        <th><?php echo __('User name') ?></th>
                        <th><?php echo __('Email') ?></th>
                        <th><?php echo __('Logins') ?></th>
                        <th><?php echo __('Last login') ?></th>
                        <th><?php echo __('Actions') ?></th>
                    </tr>
                    </thead>
 
                    <tbody>
                        <?php if ($items->count()) : ?>
                            <?php foreach ($items as $item) : ?>
                            <tr>
                                <td><?php echo $item->id ?></td>
                                <td><?php echo $item->username ?></td>
                                <td><?php echo $item->email ?></td>
                                <td><?php echo $item->logins ?></td>
                                <td><?php echo date('Y-m-d H:i:s', $item->last_login) ?></td>
                                <td>
                                    <div>
                                        <a href="<?php echo URL::site('admin/users/delete/' . $item->id) ?>"><i
                                               ></i> <?php echo __('Delete') ?></a>
                                        <a href="<?php echo URL::site('admin/users/edit/' . $item->id) ?>"><i
                                               ></i> <?php echo __('Edit') ?></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6"><?php echo __('No items') ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
 
                    <tfoot>
                        <tr>
                            <td colspan="5"><?php echo $pagination ?></td>
                            <td><?php echo __('Total: :count', array(':count' => $pagination->total_items)) ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>