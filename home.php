<div class="container-fluid overflow-visible">
    <?php
        $cards = $pdo->query("SELECT * FROM homepage")->fetchAll(PDO::FETCH_ASSOC);
        foreach($cards as $card){
            echo $card['content'];
        }
    ?>    
</div>