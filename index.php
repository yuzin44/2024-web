<?php
session_start();

// 初期のコイン設定
if (!isset($_SESSION['coins'])) {
    $_SESSION['coins'] = 100; // 初期コイン
}

// 賭け金と選択を処理
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['bet']) && isset($_POST['choice'])) {
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
