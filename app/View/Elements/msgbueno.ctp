<script>
  function mensaje_bueno(texto) {
      notify("Excelente!!", texto, {
          system: true,
          vPos: 'top',
          hPos: 'right',
          autoClose: true,
          icon: true ? "<?php echo $this->webroot; ?>img/bien.png" : '',
          iconOutside: true,
          closeButton: true,
          showCloseOnHover: true,
          groupSimilar: true
      });
  }
  mensaje_bueno("<?php echo $message; ?>");
</script>