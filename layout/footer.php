    </div> <!-- /.content -->
</div> <!-- /.wrapper -->

<!-- Global JS -->
<script src="<?= url('assets/js/bootstrap.bundle.min.js'); ?>"></script>

<!-- Script tambahan per halaman -->
<?php if (isset($pageScript)): ?>
    <?= $pageScript ?>
<?php endif; ?>

</body>
</html>
