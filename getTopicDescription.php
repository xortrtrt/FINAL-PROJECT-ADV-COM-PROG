<?php
require_once('crudDatabase.php');

if (isset($_GET['topic_id'])) {
    $topic_id = intval($_GET['topic_id']); 
    $crud = new CrudDatabase();

    $topicDetails = $crud->getTopicDescription($topic_id);

    if ($topicDetails) {
        echo json_encode([
            'success' => true,
            'content' => $topicDetails['topic_description']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'content' => 'No description found for this topic.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'content' => 'Invalid topic ID.'
    ]);
}

?>
