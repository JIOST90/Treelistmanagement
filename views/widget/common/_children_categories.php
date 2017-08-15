<?php
/**
 * @var $level int
 * @var $categories array
 * @var $category \app\models\MenuItems
 * @var $this \app\components\CommonWidget
 */

?>

<?php foreach ($categories as $category): ?>
    <li id="<?= $category->id ?>" class="<?= !$category->children ? 'count_category_none' : '' ?>">

        <div class="list-group-item category_item">
            <a href="#" data-hhh-tab="<?= $category->id ?>" data-parent-hhh-tab="<?= $category->parent_id ?>">
                <?= $category->name ?>
            </a>

            <a href="#">
                   <span class="badge pull-right">
                       <button href="#myModal" class="btn btn-default btn-xs" data-toggle="modal" data-category-action="create">
                           <span class="glyphicon glyphicon-ok" title="добавить элемент"></span>
                       </button>
                       <button href="#myModal" type="button" class="btn btn-default btn-xs" data-toggle="modal" data-category-action="update">
                           <span class="glyphicon glyphicon-pencil" title="редактировать элемент"></span>
                       </button>
                       <button href="#myModal" type="button" class="btn btn-default btn-xs" data-toggle="modal" data-category-action="delete">
                           <span class="glyphicon glyphicon-trash" title="удалить элемент"></span>
                       </button>
                       <?= $category->children ? count($category->children) : ''; ?>
                   </span>
            </a>
        </div>

        <?php if($category->children): ?>

            <ul class="children parent-<?= $category->id ?>">
                <?= $this->render('_children_categories', ['categories' => $category->children, 'level' => ++$level]) ?>
            </ul>

        <?php endif; ?>

    </li>

<?php endforeach; ?>
