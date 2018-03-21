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
<?php
 if (!empty($error->queryString)) : ?>
    <p class="notice">
        <strong>SQL Query: </strong>
        <?php h($error->queryString) ?>
    </p>
<?php endif; ?>
<?php if (!empty($error->params)) : ?>
        <strong>SQL Query Params: </strong>
        <?php Debugger::dump($error->params) ?>
<?php endif; ?>
<?php $this->element('auto_table_warning') ?>
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

<article class="content error-404-page">
    <section class="section">
        <div class="error-card">
            <div class="error-title-block">
                <h1 class="error-title">404</h1>
                <h2 class="error-sub-title">
                    Sorry, page not found
                </h2>
            </div>
            <div class="error-container">
            <br />
                <a class="btn btn-primary" href="javascript:history.back()" style="width:auto;"><i class="fa fa-angle-left"></i> Back to Previous Page</a>
            </div>
        </div>
    </section>
</article>

<?php endif; ?>