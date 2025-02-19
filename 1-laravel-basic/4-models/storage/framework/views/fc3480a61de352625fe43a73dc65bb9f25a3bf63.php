<?php $__env->startSection('titulo', 'Home'); ?>

<?php $__env->startSection('conteudo'); ?>
    <div class="conteudo-destaque">

        <div class="esquerda">
            <div class="informacoes">
                <h1>Sistema Super Gestão</h1>
                <p>Software para gestão empresarial ideal para sua empresa.<p>
                <div class="chamada">
                    <img src="<?php echo e(asset('img/check.png')); ?>">
                    <span class="texto-branco">Gestão completa e descomplicada</span>
                </div>
                <div class="chamada">
                    <img src="<?php echo e(asset('img/check.png')); ?>">
                    <span class="texto-branco">Sua empresa na nuvem</span>
                </div>
            </div>

            <div class="video">
                <img src="<?php echo e(asset('img/player_video.jpg')); ?>">
            </div>
        </div>

        <div class="direita">
            <div class="contato">
                <h1>Contato</h1>
                <p>Caso tenha qualquer dúvida por favor entre em contato com nossa equipe pelo formulário abaixo.<p>
                <?php $__env->startComponent('site.layouts._components.form_contato', ['classe' => 'borda-branca']); ?>
                <?php if (isset($__componentOriginal5fd4ee279ef26e11bb1719135c3a842ac3f4e58e)): ?>
<?php $component = $__componentOriginal5fd4ee279ef26e11bb1719135c3a842ac3f4e58e; ?>
<?php unset($__componentOriginal5fd4ee279ef26e11bb1719135c3a842ac3f4e58e); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('site.layouts.basico', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/alucard/Documents/trabalho/AULAS/Laravel/app_super_gestao/resources/views/site/principal.blade.php ENDPATH**/ ?>