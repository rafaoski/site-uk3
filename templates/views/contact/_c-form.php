<?php namespace ProcessWire;

// Submit From Page
// $from_page = isset($from_page) ? __('Message sent from: ') . $from_page : '';

// Get IP Adress
$ip = session()->getIP();
// Mail To ( Your E-Mail )
$mail_to = isset($mail_to) ? $mail_to : '';
// Privacy Page
$privacy_page = isset($privacy_page) ? $privacy_page : '';
// Mail Subject
$email_subject = isset($email_subject) ? $email_subject : '';
// Save Message
$save_message = isset($save_message) ? $save_message : '';
// Set Contact Page & Contact Items To Save Message
$contact_page = isset($contact_page) ? $contact_page : '';
$contact_item = isset($contact_item) ? $contact_item : '';
// Basic Translate
$not_fill = __('Do Not Fill First Security Input !!!');
$label_name = __('Name');
$label_email = __('E-Mail');
$label_message = __('Message');
$submit = __('Submit');
$reset = __('Reset');
$show_form = __('Show Form');
$label_success = __('Success !!! Your message has been sent');
$label_accept = __('By submitting a query, you accept');
$label_privacy = __('privacy policy');
$something_wrong = __('Something Wrong !!! Try it again');
$fill_fields = __('Fill the fields correctly !!!');
$csrf_match =  __('Stop ... Session CSRF Not Match !!!');

// If Submit Form
if ($input->post->submit) :

// IF CSRF TOKEN NOT FOUND
if (!session()->CSRF->hasValidToken()) {
    session()->Message = '<h3>' . $csrf_match . "</h3>";
    // session()->redirect('./http404');
    session()->redirect('./');
}

// Check Chidden Input
if ($input->firstname) {
    session()->Message = '<h3>' . $not_fill . "</h3>";
    // session()->redirect('./http404');
    session()->redirect('./');
}

// Sanitize Input
  $m_name = $sanitizer->text($input->post->name);
  $m_from = $sanitizer->email($input->post->email);
  $m_message = $sanitizer->text($input->post->message);

// Fill fields correctly
  if (!$m_name or !$m_from  or !$m_message or !input()->post->accept_message) {
        $session->Message = "<h3>$fill_fields</h3>";
        session()->redirect('./');
  }
// Prepare a message
    $mess_body = "<h4>$label_name:</h4> $m_name
                <h4>$label_email:</h4> $m_from
                <h4>$label_message:</h4> $m_message";

    $html = "<html><body>
                <p>$mess_body</p>
            </body></html>";

    // Send Mail
        $m = wireMail();
        // separate method call usage
        $m->to($mail_to); // specify CSV string or array for multiple addresses
        $m->from($m_from);
        $m->subject($email_subject);
        $m->body($html);
        $m->send();

    // Save Message to child page ... Template => ( contact-item )
        if ($save_message == true) {
            // save to log that can be viewed via the pw backend
                $p = new Page();
                $p->template = $contact_item;
                // $p->parent = 1017;
                $p->parent = $contact_page;
                $p->title = $m_from . ' - ' . date("Y.m.d | H:i");
                $p->e_mail = $m_from;
                $p->session_ip = $ip;
                $p->body = $mess_body;
            // https://processwire.com/api/ref/page/add-status/g/
                $p->addStatus(Page::statusHidden);
                $p->addStatus(Page::statusLocked);
                $p->save();
        }

    // Session Message
        session()->Message ="
            <h3 class='success'>$label_success</h3>
            <blockquote>
                <h4><b>$label_name:</b> $m_name</h4>
                <h4><b>$label_email:</b>  $m_from</h4>
                <h4><b>$label_message:</b></h4>
                <p>$m_message</p>
            </blockquote>";

    // Finally redirect ( refresh page ) user with Success Message
    session()->redirect('./');

else :
// Session Message
    if ($session->Message) {
        echo $session->Message;
        echo "<a href='./' class='button'>$show_form</a>";
// Show Basic Contact Form
    } else {
// CSRF Tokens
    $token_name = $this->session->CSRF->getTokenName();
    $token_value = $this->session->CSRF->getTokenValue(); ?>

        <form id='contact-form' class='c-form' action='./' method='post'>
          <fieldset>
<!-- LEGEND -->
            <legend>
              <?=ukHeading3('Contact Form',['class' => 'uk-h1']);?>
            </legend>
<!-- CSRF -->
            <input type='hidden' id='_post_token' name='<?=$token_name?>' value='<?=$token_value?>'>
<!-- HONEYPOT -->
            <input name='firstname' placeholder='<?=$not_fill?>' type='text' id='firstname' class='hide-robot'>
<!-- NAME -->
            <label class='label-name uk-label uk-margin-small'>* <?=$label_name?></label>
            <input class='uk-input' name='name' placeholder='<?=$label_name?>' autocomplete='off' type='text' required>
<!-- E-MAIL -->
            <label class='label-email uk-label uk-margin-small'>* <?=$label_email?></label>
            <input class='uk-input' name='email' placeholder='<?=$label_email?>' type='email' required>
<!-- MESSAGE -->
            <label class='label-message uk-label uk-margin-small'>* <?=$label_message?></label>
            <textarea class='uk-textarea' name='message' placeholder='<?=$label_message?>' rows='7' required></textarea>
<!-- ACCEPT PRIVACY POLICY -->
            <label class='label-check'>
              <input class='accept-message uk-checkbox' name='accept_message' type='checkbox' required>
              <small class='uk-text-uppercase'><?=$label_accept?>
                <a style='font-size: 1.3rem;' href='<?=$privacy_page?>'><?=$label_privacy?></a>.
              </small>
            </label>
            <br>
<!-- SUBMIT BUTTON -->
            <input class='uk-button uk-button-primary uk-margin-small-top' name='submit' value='<?=$submit?>' type='submit'>
<!-- RESET BUTTON -->
            <button class='uk-button uk-button-secondary uk-margin-small-top' type='reset'><?=$reset?></button>
          </fieldset>
        </form>

<?php }

    endif;

      // Remove Session Message
        session()->remove('Message');
