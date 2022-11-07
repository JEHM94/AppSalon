<?php
foreach ($alertas as $key => $mensajes) :
    foreach ($mensajes as $mensaje) :
        if ($key === NEUTRAL && !empty($usuario)) {
?>
            <a href="/reenviar?token=<?php echo $usuario->token; ?>">
                <div class="alerta <?php echo $key; ?>">
                    <?php echo $mensaje; ?>
                </div>
            </a>
        <?php } else { ?>
            <div class="alerta <?php echo $key; ?>">
                <?php echo $mensaje; ?>
            </div>
<?php
        }
    endforeach;
endforeach;
?>