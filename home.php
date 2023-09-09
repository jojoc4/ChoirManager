<div class="container-fluid overflow-visible">
    <?php
    $cards = $pdo->query("SELECT * FROM homepage")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cards as $card) {
    ?>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h4><?php echo $card['header_title']; ?></h4>
            </div>
            <div class="card-body">
                <?php echo $card['content']; ?>
            </div>
        </div>
    <?php } ?>
</div>