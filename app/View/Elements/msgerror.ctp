<script>
  function mensaje_error(texto) {
      notify("Error!!", texto, {
          system: true,
          vPos: 'top',
          hPos: 'right',
          autoClose: true,
          icon: true ? "<?php echo $this->webroot; ?>/img/mal.png" : '',
          iconOutside: true,
          closeButton: true,
          showCloseOnHover: true,
          groupSimilar: true
      });
  }
  mensaje_error("<?php echo $message; ?>");
</script>
