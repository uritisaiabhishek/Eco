<footer class="py-5">
      <div class="container text-center" style="font-size: 0.875rem;">
        <p class="">
          <a class="" href="<?php echo site_url(); ?>"><?php echo bloginfo('name'); ?></a> - Everything that needs to be done to Get success is to Connect with Right People at Right Time, Your Success is our Product
        </p>
        <p class="">Copyrights <span title="copyright">©</span> <?php echo date('Y'); ?></p>
      </div>
    </footer>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    
    <?php wp_footer(); ?>  
    <script>
      setTimeout(() => {
        const session_message =
          bootstrap.Alert.getOrCreateInstance("#session_message");
        session_message.close();
      }, 3000);
    </script>
</body>
</html>