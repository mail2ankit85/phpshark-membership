<?php 
/**
* Template Name: Dashboard Page
*
* @package WordPress
* @subpackage fixopr
*/
$queries = phpshark_membership_get_user_queries();
$response_link = site_url('respond/query');
get_header(); 
?>

<div id="primary" class="content-area">
		<main id="main" class="site-main">

        <div class="container mb-5"> 
            <div class="row"> 
                <?php 
                    if ( is_user_logged_in() ) : ?>
                        <div class="col-md-3 mb-5">
                            <?php 
                                // your code for logged in user
                                get_admin_template_part('structure','menu');
                            ?>
                        </div>
                        <div class="col-md-9">
                            <table id="example" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                            <thead>
                                <tr>
                                    <?php if( current_user_can('administrator') ):  ?>
                                        <th>Respond</th>   
                                        <th>Question</th>
                                        <th>Subject</th>
                                        <th>Email</th>              
                                        <th>Answer</th>     
                                    <?php else: ?>
                                        <th>Subject</th>
                                        <th>Question</th>
                                        <th>Answer</th>  
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php     
                                    if( current_user_can('administrator') ):          
                                        foreach( $queries as $query ):
                                            echo "<tr>";
                                            echo "<td><a href='{$response_link}?question={$query->msg_ID}'>Respond</a></td>";
                                            echo "<td>{$query->subject_text}</td>";
                                            echo "<td>{$query->description}</td>";
                                            echo "<td>{$query->email}</td>";
                                            echo "<td>{$query->response}</td>";
                                            echo "</tr>";
                                        endforeach;
                                    else: 
                                        foreach( $queries as $query ):
                                            echo "<tr>";
                                            echo "<td>{$query->subject_text}</td>";
                                            echo "<td>{$query->query_text}</td>";
                                            echo "<td>{$query->response}</td>";
                                            echo "</tr>";
                                        endforeach;
                                    endif; 
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php else : ?>
                    <div class="row"> 
                        <div class="col-md-12">
                            <?php 
                                // your code for logged out user 
                            get_admin_template_part('content','unauthorized');
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
        </div>
        </main><!-- #main -->
</div><!-- #primary -->

<?php get_footer() ?>