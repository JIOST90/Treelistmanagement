<?php

/**
 * @var $categories array
 * @var $this yii\web\View
 * @var $val \app\models\MenuItems
 * @var $model \app\models\MenuItemsForm
 */

use \app\components\CommonWidget;

$this->title = 'My Yii Application';

?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Congratulations!</h1>

<!--        <p class="lead">You have successfully created your Yii-powered application.</p>-->

<!--        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>-->
    </div>

    <?= CommonWidget::widget() ?>
</div>

<script>

    window.onload = function () {

        myModal = {
            id: 'myModal',
            idForm: '',
            action: null,
            idElem: null,
            model: {},
            open: [],
            elemName: null,
            parentIdElem: null,
            select: {
                obj: null,
                html: null
            },
            title: function (title) {
                var modelTitle = $(myModal.model).children('.modal-title')[0];
                $(modelTitle).text(title);
            },
            init: function () {
                myModal.idForm = "<?= \app\models\MenuItemsForm::className() ?>";
                myModal.select.obj = $("#menuitemsform-parent_id");
//                $(myModal.select.obj).find('option:first-child').attr('selected', 'selected');
                myModal.select.html = $(myModal.select.obj).html();
                myModal.model = $('#' + myModal.id);

                $("[data-hhh-tab]").on('click', function () {
                    var parent = $(this).data('hhh-tab');
                    var ch = $("#" + parent + " .children.parent-" + parent);
                    var is_none = (ch.css('display') == 'none');

                    if(is_none){
                        ch.show(500);
                    } else {
                        ch.hide(300);
                    }
                });

                $('#' + myModal.id + ' .form-group').css({
                    'margin-right': 'initial',
                    'margin-left': 'initial'
                });

                $("[data-category-action]").on('click', function () {
                    console.clear();
                    myModal.action = $(this).data('category-action');
                    var parent = $(this).parents(".category_item")[0];
                    var parent_el = $(parent).children("[data-hhh-tab]")[0];
                    if($(parent_el)[0] != undefined){
                        myModal.elemName = $(parent_el)[0].outerText;
                    }
                    myModal.idElem = $(parent_el).data('hhh-tab');
                    myModal.parentIdElem = $(parent_el).data('parent-hhh-tab');

                });

                $("#myModal").on('show.bs.modal', function () {
                    $(myModal.select.obj).html(myModal.select.html);
                    df(myModal.action);

                    if(myModal.action == 'create'){
                        myModal.actionFun.actionCreate();
                    } else if(myModal.action == 'update'){

                        myModal.actionFun.actionUpdate();
                    } else if(myModal.action == 'delete'){
                        myModal.actionFun.actionDelete();
                    } else {
                        df('--------------------else');
                        myModal.idElem = false;
                        myModal.actionFun.actionNew();
                    }
                });
            },
            clickOnCategory: function (select) {
                myModal.idElem = $(select).val();

                if(!myModal.idElem){
                    return false;
                }

                myModal.addInSelect();
            },
            addInSelect: function () {
                var select = $(myModal.select.obj);
                var elemId = myModal.idElem;
                df(['---------', elemId]);
                if(myModal.idElem) {
                    $.post('category/get-children-elements/' + elemId, {}, function (data) {
                        var active = null;
                        $(myModal.model).find('.groupCI').remove();
                        $.each(data, function (id, ct) {
                            if (!$('#' + select.id + ' .groupCI').is('.groupCI-' + id)) {
                                var optgroup = $('<optgroup label=" - Подкатегории: ' + ct.parentName + '"></optgroup>');
                                $(optgroup).data('groupCI-id', id);
                                $(optgroup).addClass('groupCI');
                                $(optgroup).addClass('groupCI-' + id);

                                $.each(ct.categories, function (key, value) {
                                    var opt = $("<option></option>");
                                    $(opt).val(key);
                                    $(opt).text(value);
                                    if (elemId == key) {
                                        if(myModal.action == 'update'){
                                            active = id;
                                            opt = '';
                                        } else {
                                            active = elemId;
                                        }
                                    }
                                    $(optgroup).append(opt);
                                });

                                $(select).append(optgroup);
                            }
                            df(['-------------------------------', 'value active', active]);
                        });
                        if(active){
                            $(myModal.select.obj).find('[value="' + active + '"]').attr('selected', 'selected');
                        }
                    }, "json");
                }
            },
            actionFun: {
                init: function (buttonName, isValName) {
                    var option = $(myModal.select.obj).find('option[value="' + myModal.idElem + '"]');

                    if($(option).length == 1){
                        $(option)[0].setAttribute('selected', 'selected');
                    }

                    $(myModal.model).find('button[type="submit"]').text(buttonName);

                    $('#menuitemsform-name').val( (isValName) ? myModal.elemName : '');

                    myModal.addInSelect();
                },
                actionCreate: function () {
                    df(['------------------------', 'actionCreate']);
                    myModal.actionFun.init('Создать', false);
                    $(myModal.model).find('form').attr("action", 'category/create-element');
                },
                actionUpdate: function () {
                    df(['------------------------', 'actionUpdate']);
                    if(!myModal.parentIdElem){
                        $(myModal.select.obj).html(myModal.select.html);
                        $('#menuitemsform-name').val(myModal.elemName);
                        $(myModal.model).find('button[type="submit"]').text('Сохранить');
                        $(myModal.select.obj).find('option[value="' + myModal.idElem + '"]')[0].remove();
                    } else {
                        myModal.actionFun.init('Сохранить', true);
                    }
                    $(myModal.model).find('form').attr("action", 'category/update-element/' + myModal.idElem);
                },
                actionDelete: function () {
                    df(['------------------------', 'actionDelete']);
                    if(confirm('Вы действительно хотите удалить категорию?')){
                        var form = $(myModal.model).find('form');
                        $(form).attr("action", 'category/delete-element/' + myModal.idElem);
                        $(form).submit();
                    }
                },
                actionNew: function(){
                    df(['------------------------', 'actionNew']);
                    $('#menuitemsform-name').val('');
                    $(myModal.model).find('button[type="submit"]').text('Создать');
                    $(myModal.model).find('form').attr("action", 'category/create-element');

                }
            }
        };

        var df = function ($val) {
            var cookie = $.cookie("debug");
            if(cookie!=null) {
                console.info($val);
            }
        };

        myModal.init();
    };

</script>

<style>
    .count_category_none{
        list-style-type: none;
    }
    .category_item{
        min-height:42px;
        max-width: 350px;
    }
    .children{
        display: none;
    }
    .category_item i.glyphicon-plus{
        color: rgba(12, 139, 0, 0.59);
    }
</style>




<!-- HTML-код модалки -->
<div id="myModal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
                <h4 class="modal-title">Сделайте выбор</h4>
            </div>
            <?php $form = \yii\widgets\ActiveForm::begin([
                'id' => \app\models\MenuItemsForm::className(),
                'options' => [
                    'class' => 'form-horizontal',
                    'role' => 'form',
                    'method' => 'post',
                ],
            ]); ?>
                <div class="modal-body">
                    <div class="form-group">

                        <?= $form->field($model, 'name')->textInput(['placeholder' => 'Введите название категории'])->label('Название') ?>

                        <?= $form->field($model, 'parent_id')
                            ->dropDownList($categories,
                                [
                                    'size ' => 25,
                                    'prompt' => 'Выберете категорию',
                                    'onClick' => 'myModal.clickOnCategory(this);',
                                ])->label('Категории') ?>

<!--                        --><?//= $form->field($model, 'parent_id')
//                        ->dr()
//                        ?>
<!--                        echo CHtml::activeDropDownList($model,'values',-->
<!--                        $country,-->
<!--                        array('multiple'=>'multiple',-->
<!--                        'name'=>'values',-->
<!--                        'class'=>'multiselect',-->
<!--                        'title'=>"страны",-->
<!--                        'options' => $selectedValues,-->
<!--                        ));-->
                    </div>
                </div>
                <div class="modal-footer">
                    <?= \yii\helpers\Html::submitButton('Сохранить', ['class' => 'btn btn-primary',]) ?>
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Закрыть</button>
                </div>
            <?php \yii\widgets\ActiveForm::end() ?>
        </div>
    </div>
</div>
