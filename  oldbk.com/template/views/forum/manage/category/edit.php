<?php
/**
 *
 *
 * @var \components\Model\Forum $selected_category
 */

?>

<a href="<?= $app->urlFor('manage_category_list') ?>">
    <img title="" src="/assets/forum/i/undo.png" width="12" height="12">
</a>


<div class="row text-center">
    <div class="col">
        <h4>�������������� �����������</h4>
    </div>
</div>

<div class="row">
    <div class="col">

        <form action="<?= $app->urlFor('manage_category_edit', ['id' => $selected_category->id]) ?>" method="post">

            <div class="form-group row">
                <label for="inputText" class="col-sm-2 col-form-label">��������</label>
                <div class="col-sm-8">
                    <input type="text" name="topic" class="form-control" id="inputText" placeholder="��������" value="<?= $selected_category->topic ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputDesc" class="col-sm-2 col-form-label">��������</label>
                <div class="col-sm-8">
                    <input type="text" name="text" class="form-control" id="inputDesc" placeholder="��������" value="<?= $selected_category->text ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="inputFix" class="col-sm-2 col-form-label">�������</label>
                <div class="col-sm-8">
                    <input type="text" name="fix" class="form-control" id="inputFix" placeholder="�������" value="<?= $selected_category->fix ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="input-min_align" class="col-sm-2 col-form-label">min_align</label>
                <div class="col-sm-8">
                    <input type="text" name="min_align" class="form-control" id="input-min_align" placeholder="min_align" value="<?= $selected_category->min_align ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="input-max_align" class="col-sm-2 col-form-label">max_align</label>
                <div class="col-sm-8">
                    <input type="text" name="max_align" class="form-control" id="input-max_align" placeholder="max_align" value="<?= $selected_category->max_align ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="input-min_level" class="col-sm-2 col-form-label">min_level</label>
                <div class="col-sm-8">
                    <input type="text" name="min_level" class="form-control" id="input-min_level" placeholder="min_level" value="<?= $selected_category->min_level ?>">
                </div>
            </div>

            <div class="form-group row">
                <label for="input-max_level" class="col-sm-2 col-form-label">max_level</label>
                <div class="col-sm-8">
                    <input type="text" name="max_level" class="form-control" id="input-max_level" placeholder="max_level" value="<?= $selected_category->max_level ?>">
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">������ ���� ����</div>
                <div class="col-sm-10">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" name="only_own" value="1" type="checkbox" <?= $selected_category->only_own ? 'checked' : '' ?>> ����������� ������ ������ ���� ����
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">������ ��� ��������</div>
                <div class="col-sm-10">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" name="only_tester" value="1" type="checkbox" <?= $selected_category->is_test ? 'checked' : '' ?>> ����������� ������ ������ ���� ��� ��������
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-2">������</div>
                <div class="col-sm-10">
                    <div class="form-check">
                        <label class="form-check-label">
                            <input class="form-check-input" name="is_closed" value="1" type="checkbox" <?= $selected_category->is_closed ? 'checked' : '' ?>> ������ �����
                        </label>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-success">���������</button>
                </div>
            </div>
        </form>

    </div>
</div>