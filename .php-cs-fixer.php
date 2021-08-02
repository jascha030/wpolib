<?php
/*
 * This document has been generated with
 * https://mlocati.github.io/php-cs-fixer-configurator/#version:3.0.0|configurator
 * you can change this configuration by importing this file.
 */
$config = new PhpCsFixer\Config();

return $config
    ->setRules([
        'blank_line_after_namespace'                    => true,
        'blank_line_after_opening_tag'                  => true,
        'compact_nullable_typehint'                     => true,
        'constant_case'                                 => true,
        'declare_equal_normalize'                       => true,
        'elseif'                                        => true,
        'encoding'                                      => true,
        'full_opening_tag'                              => true,
        'function_declaration'                          => true,
        'indentation_type'                              => true,
        'line_ending'                                   => true,
        'lowercase_cast'                                => true,
        'lowercase_keywords'                            => true,
        'lowercase_static_reference'                    => true,
        'method_argument_space'                         => ['on_multiline' => 'ensure_fully_multiline'],
        'new_with_braces'                               => true,
        'no_blank_lines_after_class_opening'            => true,
        'no_break_comment'                              => true,
        'no_closing_tag'                                => true,
        'no_leading_import_slash'                       => true,
        'no_spaces_after_function_name'                 => true,
        'no_spaces_inside_parenthesis'                  => true,
        'no_trailing_whitespace'                        => true,
        'no_trailing_whitespace_in_comment'             => true,
        'no_whitespace_in_blank_line'                   => true,
        'ordered_class_elements'                        => ['order' => ['use_trait']],
        'ordered_imports'                               => [
            'imports_order'  => [
                'class',
                'function',
                'const',
            ],
            'sort_algorithm' => 'none',
        ],
        'return_type_declaration'                       => true,
        'short_scalar_cast'                             => true,
        'single_blank_line_at_eof'                      => true,
        'single_blank_line_before_namespace'            => true,
        'single_class_element_per_statement'            => ['elements' => ['property']],
        'single_import_per_statement'                   => true,
        'single_line_after_imports'                     => true,
        'single_trait_insert_per_statement'             => true,
        'switch_case_semicolon_to_colon'                => true,
        'switch_case_space'                             => true,
        'ternary_operator_spaces'                       => true,
        'visibility_required'                           => ['elements' => ['const', 'method', 'property']],
        'array_syntax'                                  => ['syntax' => 'short'],
        'align_multiline_comment'                       => true,
        'array_indentation'                             => true,
        'array_push'                                    => true,
        'backtick_to_shell_exec'                        => true,
        'binary_operator_spaces'                        => ['default' => 'align'],
        'blank_line_before_statement'                   => [
            'statements' => [
                'break',
                'case',
                'continue',
                'declare',
                'default',
                'exit',
                'goto',
                'include',
                'include_once',
                'require',
                'require_once',
                'return',
                'switch',
                'throw',
                'try',
            ],
        ],
        'braces'                                        => [
            'allow_single_line_anonymous_class_with_empty_body' => true,
            'allow_single_line_closure'                         => true,
        ],
        'cast_spaces'                                   => true,
        'class_attributes_separation'                   => ['elements' => ['method' => 'one']],
        'class_definition'                              => ['single_line' => true],
        'clean_namespace'                               => true,
        'combine_consecutive_issets'                    => true,
        'combine_consecutive_unsets'                    => true,
        'combine_nested_dirname'                        => true,
        'concat_space'                                  => true,
        'dir_constant'                                  => true,
        'echo_tag_syntax'                               => true,
        'ereg_to_preg'                                  => true,
        'error_suppression'                             => true,
        'escape_implicit_backslashes'                   => true,
        'explicit_indirect_variable'                    => true,
        'explicit_string_variable'                      => true,
        'fopen_flag_order'                              => true,
        'fopen_flags'                                   => ['b_mode' => false],
        'fully_qualified_strict_types'                  => true,
        'function_to_constant'                          => true,
        'function_typehint_space'                       => true,
        'general_phpdoc_tag_rename'                     => ['replacements' => ['inheritDocs' => 'inheritDoc']],
        'heredoc_to_nowdoc'                             => true,
        'implode_call'                                  => true,
        'include'                                       => true,
        'increment_style'                               => true,
        'is_null'                                       => true,
        'lambda_not_used_import'                        => true,
        'linebreak_after_opening_tag'                   => true,
        'logical_operators'                             => true,
        'magic_constant_casing'                         => true,
        'magic_method_casing'                           => true,
        'method_chaining_indentation'                   => true,
        'modernize_types_casting'                       => true,
        'multiline_comment_opening_closing'             => true,
        'multiline_whitespace_before_semicolons'        => ['strategy' => 'new_line_for_chained_calls'],
        'native_constant_invocation'                    => true,
        'native_function_casing'                        => true,
        'native_function_invocation'                    => [
            'include' => ['@compiler_optimized'],
            'scope'   => 'namespaced',
            'strict'  => true,
        ],
        'native_function_type_declaration_casing'       => true,
        'no_alias_functions'                            => true,
        'no_alias_language_construct_call'              => true,
        'no_alternative_syntax'                         => true,
        'no_binary_string'                              => true,
        'no_blank_lines_after_phpdoc'                   => true,
        'no_empty_comment'                              => true,
        'no_empty_phpdoc'                               => true,
        'no_empty_statement'                            => true,
        'no_extra_blank_lines'                          => [
            'tokens' => [
                'break',
                'case',
                'continue',
                'curly_brace_block',
                'default',
                'extra',
                'parenthesis_brace_block',
                'return',
                'square_brace_block',
                'switch',
                'throw',
                'use',
                'use_trait',
            ],
        ],
        'no_homoglyph_names'                            => true,
        'no_leading_namespace_whitespace'               => true,
        'no_mixed_echo_print'                           => true,
        'no_multiline_whitespace_around_double_arrow'   => true,
        'no_null_property_initialization'               => true,
        'no_php4_constructor'                           => true,
        'no_short_bool_cast'                            => true,
        'no_singleline_whitespace_before_semicolons'    => true,
        'no_spaces_around_offset'                       => true,
        'no_superfluous_elseif'                         => true,
        'no_superfluous_phpdoc_tags'                    => ['allow_mixed' => true, 'allow_unused_params' => true],
        'no_trailing_comma_in_list_call'                => true,
        'no_trailing_comma_in_singleline_array'         => true,
        'no_trailing_whitespace_in_string'              => true,
        'no_unneeded_control_parentheses'               => [
            'statements' => [
                'break',
                'clone',
                'continue',
                'echo_print',
                'return',
                'switch_case',
                'yield',
                'yield_from',
            ],
        ],
        'no_unneeded_curly_braces'                      => ['namespaces' => true],
        'no_unneeded_final_method'                      => true,
        'no_unreachable_default_argument_value'         => true,
        'no_unset_cast'                                 => true,
        'no_unused_imports'                             => true,
        'no_useless_else'                               => true,
        'no_useless_return'                             => true,
        'no_useless_sprintf'                            => true,
        'no_whitespace_before_comma_in_array'           => true,
        'non_printable_character'                       => true,
        'normalize_index_brace'                         => true,
        'object_operator_without_whitespace'            => true,
        'operator_linebreak'                            => ['only_booleans' => true],
        'ordered_traits'                                => true,
        'php_unit_construct'                            => true,
        'php_unit_fqcn_annotation'                      => true,
        'php_unit_internal_class'                       => true,
        'php_unit_method_casing'                        => true,
        'php_unit_mock_short_will_return'               => true,
        'php_unit_set_up_tear_down_visibility'          => true,
        'php_unit_test_annotation'                      => true,
        'php_unit_test_class_requires_covers'           => true,
        'phpdoc_add_missing_param_annotation'           => true,
        'phpdoc_align'                                  => true,
        'phpdoc_annotation_without_dot'                 => true,
        'phpdoc_indent'                                 => true,
        'phpdoc_inline_tag_normalizer'                  => true,
        'phpdoc_no_access'                              => true,
        'phpdoc_no_alias_tag'                           => true,
        'phpdoc_no_empty_return'                        => true,
        'phpdoc_no_package'                             => true,
        'phpdoc_no_useless_inheritdoc'                  => true,
        'phpdoc_order'                                  => true,
        'phpdoc_order_by_value'                         => true,
        'phpdoc_return_self_reference'                  => true,
        'phpdoc_scalar'                                 => true,
        'phpdoc_separation'                             => true,
        'phpdoc_single_line_var_spacing'                => true,
        'phpdoc_summary'                                => true,
        'phpdoc_tag_type'                               => ['tags' => ['inheritDoc' => 'inline']],
        'phpdoc_to_comment'                             => true,
        'phpdoc_trim'                                   => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_types'                                  => true,
        'phpdoc_types_order'                            => true,
        'phpdoc_var_annotation_correct_order'           => true,
        'phpdoc_var_without_name'                       => true,
        'pow_to_exponentiation'                         => true,
        'protected_to_private'                          => true,
        'psr_autoloading'                               => true,
        'return_assignment'                             => true,
        'self_accessor'                                 => true,
        'semicolon_after_instruction'                   => true,
        'set_type_to_cast'                              => true,
        'simple_to_complex_string_variable'             => true,
        'single_line_comment_style'                     => true,
        'single_line_throw'                             => true,
        'single_quote'                                  => true,
        'single_space_after_construct'                  => true,
        'space_after_semicolon'                         => ['remove_in_empty_for_expressions' => true],
        'standardize_increment'                         => true,
        'standardize_not_equals'                        => true,
        'string_line_ending'                            => true,
        'switch_continue_to_break'                      => true,
        'ternary_to_elvis_operator'                     => true,
        'trailing_comma_in_multiline'                   => true,
        'trim_array_spaces'                             => true,
        'unary_operator_spaces'                         => true,
        'whitespace_after_comma_in_array'               => true,
        'yoda_style'                                    => true,
    ])
    ->setFinder(
        PhpCsFixer\Finder::create()
                         ->exclude('vendor')
                         ->in(__DIR__)
    )
;