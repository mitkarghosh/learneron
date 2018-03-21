<?php
use Cake\Core\Configure;
use Cake\Error\Debugger;
use Cake\Routing\Router;

//$this->layout = 'error';

if (Configure::read('debug')):
    $this->layout = 'dev_error';

    $this->assign('title', $message);
    $this->assign('templateName', 'error400.ctp');

    $this->start('file');
?>
<!-- custom -->
<?php if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?php h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?= $this->element('auto_table_warning') ?>
<?php
    if (extension_loaded('xdebug')):
        xdebug_print_function_stack();
    endif;

    $this->end();
?>
<h2><?php h($message) ?></h2>
<p class="error">
    <strong><?php __d('cake', 'Error') ?>: </strong>
    <?php __d('cake', 'The requested address {0} was not found on this server.', "<strong>'{$url}'</strong>") ?>
</p>
<?php else: ?>
  <section class="cart-top account-top">
    <div class="container" style="text-align:center; margin:50px 0 20px 0;">
		<img src="<?php echo Router::url('/', true); ?>images/404_error_page_not_found.jpg" alt="Page not found" />
    </div>
    <div class="error-container" style="text-align:center; margin:30px 0 40px 0;">
        <a class="btn-normal" href="<?php echo Router::url('/', true);?>"><i class="fa fa-angle-left"></i> Back to Home</a>
    </div>
  </section>
<?php endif; ?>