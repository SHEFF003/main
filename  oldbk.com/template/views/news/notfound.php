<? if (isset($flash['errors'])) : ?>

    <div class="row">
        <div class="col py-3 px-5">
            <div class="card border-secondary text-center">
                <div class="card-header">
                    <h4 class="card-title">������!</h4>
                </div>
                <div class="card-body text-secondary">

                    <? foreach ($flash['errors'] as $error) : ?>
                        <p class="card-text"><?=$error?></p>
                    <? endforeach; ?>
                    <a href="/news" class="btn btn-primary text-white">�� �������</a>
                </div>
            </div>
        </div>
    </div>

<? endif; ?>
