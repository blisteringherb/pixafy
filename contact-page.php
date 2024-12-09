<?php
/*
 * Template Name: Contact Page
 */
?>
<?php get_header(); ?>
<?php
$nameError = '';
$emailError = '';
$commentError = '';
if (isset($_POST['submitted'])) {
    if (trim($_POST['contactName']) === '') {
        $nameError = 'Please enter your name.';
        $hasError = true;
    } else {
        $name = trim($_POST['contactName']);
    }
    if (trim($_POST['email']) === '') {
        $emailError = 'Please enter your email address.';
        $hasError = true;
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $emailError = 'You entered an invalid email address.';
        $hasError = true;
    } else {
        $email = trim($_POST['email']);
    }
    if (trim($_POST['comments']) === '') {
        $commentError = 'Please enter a message.';
        $hasError = true;
    } else {
        if (function_exists('stripslashes')) {
            $comments = stripslashes(trim($_POST['comments']));
        } else {
            $comments = trim($_POST['comments']);
        }
    }
    if (!isset($hasError)) {
        $emailTo = get_option('tz_email');
        if (!isset($emailTo) || ($emailTo == '')) {
            $emailTo = get_option('admin_email');
        }
        $subject = '[PHP Snippets] From ' . $name;
        $body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
        $headers = 'From: ' . $name . ' <' . $emailTo . '>' . "\r\n" . 'Reply-To: ' . $email;
        mail($emailTo, $subject, $body, $headers);
        $emailSent = true;
    }
}
?>

<div class="post-wrapper hero-section">
	<div class="container">
		<div class="row">
			<div class="col-md-8">

				<div id="primary" class="content-area">
					<main id="main" class="site-main" role="main">

						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php pixafy_the_breadcrumb(); ?>
							<header class="entry-header">
								<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							</header><!-- .entry-header -->

							<div class="entry-content">
								<?php the_content(); ?>
								<?php if (have_posts()) while (have_posts()) : the_post(); ?>
                                <?php the_content(); ?>
                                    <?php if (isset($emailSent) && $emailSent == true) { ?>
                                        <div class="thanks">
                                            <p>Thankyou for contacting us.</p>
                                        </div>
                                    <?php } else { ?>
                                    <?php if (isset($hasError) || isset($captchaError)) { ?>
                                        <p class="error">Sorry, an error occured. </p>
                                    <?php } ?>
                                    <form action="<?php the_permalink(); ?>" id="contactForm" class="contactform" method="post">      
                                        <input type="text"  id="contactName" name="contactName"  value="<?php if (isset($_POST['contactName']))
                                echo $_POST['contactName']; ?>" class="required requiredField" placeholder="Your Name" required/>
                                        <?php if ($nameError != '') { ?>
                                            <span class="error"> <?php echo $nameError; ?> </span>
                                        <?php } ?>
                                        <input type="email" name="email" id="email" value="<?php if (isset($_POST['email'])) echo $_POST['email']; ?>" class="required requiredField email" placeholder="Your Email" required/>
                                        <?php if ($emailError != '') { ?>
                                            <span class="error"> <?php echo $emailError; ?> </span>
                                        <?php } ?>               
                                        <textarea name="comments" id="commentsText" rows="20" cols="30" class="required requiredField" placeholder="Your Message" required><?php if (isset($_POST['comments'])) {
                                            if (function_exists('stripslashes')) {
                                                echo stripslashes($_POST['comments']);
                                            } else {
                                                echo $_POST['comments'];
                                            }
                                        } ?></textarea>

                                        <input class="submit" type="submit" value="<?php echo "Your Message" ?>"/>
                                        <input type="hidden" name="submitted" id="submitted" value="true" />
                                        </form>   
                                    <?php } ?>
                                <?php endwhile; ?>
							</div><!-- .entry-content -->

							<footer class="entry-footer">
								<?php edit_post_link( __( 'Edit', 'pixafy' ), '<span class="edit-link">', '</span>' ); ?>
							</footer><!-- .entry-footer -->
						</article><!-- #post-## -->

					</main><!-- #main -->
				</div><!-- #primary -->

			</div><!-- col-md-8 -->
			
			<div class="col-md-4">
				<?php get_sidebar(); ?>
			</div><!-- col-md-4 -->

		</div><!-- row -->
	</div><!-- container -->
</div><!-- post-wrapper -->

<?php get_footer(); ?>