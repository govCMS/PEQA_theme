<?php
/**
 * @file
 * The primary PHP file for this theme.
 */

/**
 * Implements theme_preprocess_html().
 */
function peqa_bootstrap_preprocess_html(&$variables) {
  // Add legacy classes.
  $variables['classes_array'][] = drupal_html_class('custom-background');
  $variables['classes_array'][] = drupal_html_class('searchPos');
  if (drupal_is_front_page()) {
    $variables['classes_array'][] = drupal_html_class('home');
    $variables['classes_array'][] = drupal_html_class('blog');
  }
}

// Add scripts.min.js at end of body tag.
$theme_path = drupal_get_path('theme', 'peqa_bootstrap');
drupal_add_js(
  $theme_path . '/build/js-custom/peqa-scripts.min.js',
  [
    'type' => 'file',
    'scope' => 'footer',
  ]
);

/**
 * Implements hook_form_alter().
 */
function peqa_bootstrap_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id === 'search_api_page_search_form_default_search') {
    // Modify placeholder text in search field.
    $form['keys_1']['#title'] = t('Search');
    $form['keys_1']['#attributes']['placeholder'] = t('Search...');
  }
}

/**
 * Implements hook_js_alter().
 */
function peqa_bootstrap_js_alter(&$javascript) {
  // Use updated jQuery library on all but some paths.
  $node_admin_paths = [
    'node/*/edit',
    'node/add',
    'node/add/*',
  ];
  $replace_jquery = TRUE;
  if (path_is_admin(current_path())) {
    $replace_jquery = FALSE;
  }
  else {
    foreach ($node_admin_paths as $node_admin_path) {
      if (drupal_match_path(current_path(), $node_admin_path)) {
        $replace_jquery = FALSE;
      }
    }
  }
  // Swap out jQuery to use an updated version of the library.
  if ($replace_jquery) {
    $javascript['misc/jquery.js']['data'] = drupal_get_path('theme', 'peqa_bootstrap') . '/js/jquery.min.js';
  }
}

/**
 * Implements hook_preprocess_entity().
 */
function peqa_bootstrap_preprocess_entity(&$variables, $hook) {
  // Enable use of function peqa_bootstrap_preprocess_entity_[entity_type]().
  $function = __FUNCTION__ . '_' . $variables['entity_type'];
  if (function_exists($function)) {
    $function($variables, $hook);
  }
}

/**
 * Override or insert variables into the bean templates.
 */
function peqa_bootstrap_preprocess_entity_bean(&$vars) {
  // Replace webform container block with content from webform block. This is
  // required as webforms are displayed within bean block containers, in order
  // to allow placement using Context module.
  $bean = $vars['bean'];
  $webform_block_container_deltas = [
    'peqa_webform_feedback',
    'peqa_webform_comment_form',
  ];

  if (in_array($bean->delta, $webform_block_container_deltas)) {
    $webform_block_mapping = variable_get('webform_block_mapping', []);
    $webform_delta = 'client-block-' . $webform_block_mapping[$bean->delta];

    // Replace webform container block with title and content from webform
    // block.
    $block = module_invoke('webform', 'block_view', $webform_delta);
    $vars['title'] = $block['subject'];
    $vars['content'] = $block['content'];
  }
}

function peqa_bootstrap_preprocess_node(&$vars) {
  $theuser = user_load($vars['uid']);
  $theusername = t('<a href="/author/' . $theuser->name . '">' . $theuser->name . '</a>');
  $vars['submitted'] =  t('Posted on !datetime by !username',
    array(
      '!datetime' => $vars['date'],
      '!username' => $theusername,
    ));
}
