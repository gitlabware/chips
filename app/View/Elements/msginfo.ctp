<script>
  function mensaje_info(texto) {
      notify("Informacion!!", texto, {
          system: true,
          vPos: 'top',
          hPos: 'left',
          autoClose: false,
          icon: false ,
          iconOutside: true,
          closeButton: true,
          showCloseOnHover: true,
          groupSimilar: true
      });
  }
  mensaje_info("<?php echo $message; ?>");
</script>