echo "
                            <div class='comment-item'>
                                <div class='comment-author'>
                                    <p><a class='img-url' href='user.php?user=$commenter'>$commenter</a> on $when</p>
                                </div>
                                <div class='comment-content'>
                                    <p>" . $row['comment_text'] . "</p>
                                </div>
                            </div>";