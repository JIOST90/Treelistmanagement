<?php
/**
 * @var $level int
 * @var $categories array
 * @var $this \app\components\CommonWidget
 */

?>

<div class="body-content">
    <ul class="nav nav-pills nav-stacked">
        <li class="count_category_none">

            <div class="list-group-item category_item">
                <a href="#myModal" data-toggle="modal" data-category-action="none">
                    <i class="glyphicon glyphicon-plus"></i>
                    Добавить категорию
                </a>
            </div>
        </li>
        <?= $this->render('_children_categories', ['categories' => $categories, 'level' => $level]) ?>
    </ul>
</div>
