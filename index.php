<?php
session_start();


// 初期のコイン設定
if (!isset($_SESSION['coins'])) {
    $_SESSION['coins'] = 100; // 初期コイン
}

// 賭け金と選択を処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bet = (int)$_POST['bet'];
    $playerChoice = (int)$_POST['choice'];
    $computerChoice = rand(0, 2);

    // じゃんけんの勝敗を判定
    $result = '';
    if ($playerChoice === $computerChoice) {
        $result = "引き分け";
    } elseif (
        ($playerChoice === 0 && $computerChoice === 1) || 
        ($playerChoice === 1 && $computerChoice === 2) || 
        ($playerChoice === 2 && $computerChoice === 0)
    ) {
        $result = "勝ち";
        $_SESSION['coins'] += $bet; // 勝った場合は賭け金分増える
    } else {
        $result = "負け";
        $_SESSION['coins'] -= $bet; // 負けた場合は賭け金分減る
    }
    $choices = ["グー", "チョキ", "パー"];
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>じゃんけんギャンブルゲーム</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>じゃんけんギャンブルゲーム</h1>
        <p>現在のコイン: <?php echo $_SESSION['coins']; ?></p>

        <?php if (isset($result)) : ?>
            <div class="result">
                <p>あなたの選択: <?php echo $choices[$playerChoice]; ?></p>
                <p>コンピュータの選択: <?php echo $choices[$computerChoice]; ?></p>
                <p>結果: <?php echo $result; ?></p>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <label>賭け金を入力してください（最大 <?php echo $_SESSION['coins']; ?> コイン）:</label>
            <input type="number" name="bet" min="1" max="<?php echo $_SESSION['coins']; ?>" required>

            <label>じゃんけんを選んでください:</label>
            <div class="choices">
                <label><input type="radio" name="choice" value="0" required> グー</label>
                <label><input type="radio" name="choice" value="1"> チョキ</label>
                <label><input type="radio" name="choice" value="2"> パー</label>
            </div>

            <button type="submit">勝負する！</button>
        </form>

        <p class="note">コインがなくなるとゲームオーバーです。</p>
    </div>
</body>
</html>