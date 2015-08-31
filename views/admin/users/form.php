<?php defined('SYSPATH') or die('No direct script access.');
 
/**
 * @var array           $config       Global blog configuration
 * @var Model_User      $user         Global Kohana user object
 * @var string          $message      Global message
 * @var string          $message_type Global message type string
 * @var array           $item         Current item data
 * @var array           $errors       Errors array
 * @var Database_Result $roles        All roles list
 *
 * @author     Novichkov Sergey(Radik) <novichkovsergey@yandex.ru>
 * @copyright  Copyrights (c) 2012 Novichkov Sergey
 */
?>
<form action="<?php echo URL::site('/admin/users/save') ?>" method="post" name="user-form">
    <div>
        <div>
            <fieldset>
                <legend><?php echo __('Common') ?></legend>
 
                <div>
                    <label for="username"><?php echo __('User name') ?>:</label>
                    <div>
                        <input type="text" name="username" id="username" value="<?php echo Arr::get($item, 'username') ?>"/>
                        <?php if(isset($errors)) if (Arr::get($errors, 'username')) : ?>
                            <div><?php echo Arr::get($errors, 'username') ?></div>
                        <?php endif; ?>
                    </div>
                </div>
 
                <div>
                    <label for="email"><?php echo __('Email') ?>:</label>
                    <div>
                        <input type="text" name="email" id="email" value="<?php echo Arr::get($item, 'email') ?>"/>
                        <?php if(isset($errors)) if (Arr::get($errors, 'email')) : ?>
                            <div><?php echo Arr::get($errors, 'email') ?></div>
                        <?php endif; ?>
                    </div>
                </div>
 
                <div>
                    <label for="password"><?php echo __('Password') ?>:</label>
                    <div>
                        <input type="password" name="password" id="password"/>
                        <?php if(isset($errors)) if (Arr::get($errors, 'password')) : ?>
                            <div><?php echo Arr::get($errors, 'password') ?></div>
                        <?php endif; ?>
                    </div>
                </div>
 
                <div>
                    <label for="password_confirm"><?php echo __('Password confirm') ?>:</label>
                    <div>
                        <input type="password" name="password_confirm" id="password_confirm"/>
                        <?php if(isset($errors)) if (Arr::get($errors, 'password_confirm')) : ?>
                            <div><?php echo Arr::get($errors, 'password_confirm') ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </fieldset>
        </div>
        <div>
            <fieldset>
                <legend><?php echo __('Access') ?></legend>
                <div>
                    <label><?php echo __('Roles') ?>:</label>
                    <?php foreach ($roles as $role) : ?>
                        <label>
                            <?php echo $role->name ?>
                            <input id="role<?php echo $role->id ?>" type="checkbox" name="roles[]" value="<?php echo $role->id ?>"
                                <?php if (in_array($role->id, Arr::get($item, 'roles',array()))) : ?> checked="checked" <?php endif ?>/>
                        </label>
                    <?php endforeach; ?>
                </div>
            </fieldset>
        </div>
    </div>
    <div>
        <div>
            <div>
                <input type="submit" name="back" value="<?php echo __('Back') ?>" />
                <input type="submit" name="save" value="<?php echo __('Save') ?>" />
            </div>
        </div>
 
        <input type="hidden" name="id" value="<?php echo Arr::get($item, 'id') ?>">
    </div>
</form>
