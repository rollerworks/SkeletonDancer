TBD.

# This is the configuration file used by SkeletonDancer to execute generators.
# And allows to automate most of the work for you.
#
# Tip: Generators, Configurators and ExpressionLanguage FunctionProviders all support
# service-injection for dependency management.
#
# See: https://github.com/rollerworks/SkeletonDancer/doc/service-injection.md for
# more information.

# Optionally you can choose to separate your configuration into multiple
# smaller files, loaded relative from the `.dancer` folder.
#
# Note a profile's "generators" and "import" must be defined completely as it will
# be overwritten rather then being merged!
#
# Instead of overwriting you can also choose to create your own, and then import
# the base profile.
#
# import: [ 'config/profiles.yml' ]

# Generators configuration
#
# By default the generate command will ask for all required questions
# but it's possible to automate this when all questions can be auto guessed.
#

# When a file already exists (and there contents don't equal), you will be (ask)ed what to do.
# Instead of making a choice for each file you can choose to: 'skip', 'force' (aka overwrite)
# or 'backup' the original file.
#
# Note. Back-ups names are incremental, so when there is already a backup
# for the given file, it will named .bak0, .bak1 respectively.
#
# overwrite: ask

# Once interactive mode is disabled, the system needs to know which profile to use when.
# Fortunately SkeletonDancer provides two ways to automate this:
#
# pattern-map: Use an associative array where the key is a relative path like 'Bundles'
#              or a complete regex. See http://symfony.com/doc/current/components/finder.html#path
#              for more information. And the value is the profile-name. Eg: `{ 'Bundles/': symfony-bundle }`
#
# Custom class: Specify an autoloadable class (see autoloading section below)
#               with a `resolve()` method that receives the current folder-name (relative)
#               and a `Rollerworks\Tools\SkeletonDancer\Configuration\Config` instance.
#               And returns the resolved profile-name. Eg. "Acme\SkeletonDancer\ProfileResolver".
#
# Note: The path is relative to the project's root-folder, not the current directory.
#
# profile-resolver: ~

# Some profiles share the same generators (and configurators).
# Instead of having to duplicate all values for all profiles you can
# specify the shared defaults here.
#
# Variables are used 
#
# Variables allow for higly custom
# default values. A variable is resolved everytime it's requested.
#
# A value can be a constant (as-is) or start with an `@` to be eveluated as an expression
# http://symfony.com/doc/current/components/expression_language/syntax.html

#
# Tip: Defaults are used as they come, you can define custom defaults
# that are only used by other defaults (using the expression language)
# and never used by configurators.
#
# A value can be a constant (as-is) or start with an `@` to be eveluated as an expression
# http://symfony.com/doc/current/components/expression_language/syntax.html
#
# Caution: variables are resolved by order, you cannot reference a variable
# that's defined later in the list.
#
# Examples:
# foo: "my_default_value" # Value used as-is, no expression used.
# bar: "@foo" # uses the value of variable `foo` as-is
# peep: "@@foo" # will be transformed to `@foo`, and will not evaluated as an expression
# foobar: "@substr(foo, 0, 2)" # will run variable `foo` trough the substr() function
#
# Expressions are a powerful tool to make your defaults more dynamic.
# To get a value from the configuration use the `get_config()` function like:
# namespace: "@'Acme\\Application\\' ~ ucfirst(get_config('current_dir_name'))"
#
# defaults:
{% if shared_defaults is not empty %}
#    {{ shared_defaults|yaml_dump|indent_lines|comment_lines('#') }}
{%- endif %}

# Some profiles share the same generators (and configurators).
# Instead of having to duplicate all values for all profiles you can
# specify the shared defaults here.
#
# Tip: Defaults are used as they come, you can define custom defaults
# that are only used by other defaults (using the expression language)
# and never used by configurators.
#
# A value can be a constant (as-is) or start with an `@` to be eveluated as an expression
# http://symfony.com/doc/current/components/expression_language/syntax.html
#
# Caution: variables are resolved by order, you cannot reference a variable
# that's defined later in the list.
#
# Examples:
# foo: "my_default_value" # Value used as-is, no expression used.
# bar: "@foo" # uses the value of variable `foo` as-is
# peep: "@@foo" # will be transformed to `@foo`, and will not evaluated as an expression
# foobar: "@substr(foo, 0, 2)" # will run variable `foo` trough the substr() function
#
# Expressions are a powerful tool to make your defaults more dynamic.
# To get a value from the configuration use the `get_config()` function like:
# namespace: "@'Acme\\Application\\' ~ ucfirst(get_config('current_dir_name'))"
#
# defaults:
{% if shared_defaults is not empty %}
#    {{ shared_defaults|yaml_dump|indent_lines|comment_lines('#') }}
{%- endif %}

# SkeletonDancer already comes pre-bundled with many profiles.
# But it's also possible to define your own, or overwrite existing profiles.
#
# Note: If you only want to overwrite a small portion it may be better to overwrite
# the template(s) rather then creating a completely new generator.
#
# profiles:
#     # Name of the profile, in lowercase
#     my-profile:
#         # Give a nice description about what this profile does.
#         description: Generates the directory structure of a custom module.
#         # Optionally import other profiles
#         # import: [ composer-package ]
#
#         # The variables of this profile.
#         # This will be merged with the shared variables and variables from imported profiles.
#         variables: { }
#
#         # The defaults of this profile.
#         # This will be merged with the shared defaults and defaults from imported profiles.
#         defaults: { }
#
#         # The generators of this profile (optional)
#         # This will be merged with the generators list imported from the other profiles.
#         # Must be an array with Fully qualified class-names eg. [ 'Acme\SkeletonDancer\Generator\MyGenerator' ]
#         generators: []
#
#    # This lists all the profiles your project supports
#    # Defaults specific for the profiles are defined for ease of use.
#    #
#    {{ profiles_defaults|yaml_dump|indent_lines|comment_lines('#') }}

# Autoloading of custom classes (generators, configurators, profile-resolver).
# As SkeletonDancer operates separately from your application or package.
# It doesn't know how to load your classes, fortunately you can configure the autoloading.
# You can use both file-loading (files) and the PSR-4 loader ('psr-4').
#
# Note: Unlike all SkeletonDancer configuration, the path of classes
# is loaded from the project folder (where the .dancer folder is located).
#
# Tip: It's possible to load your projects Composer autoloader
# to easily access all files. Only do this when setting-up your autoloading
# would take much work.

# autoloading:
#     files: [ 'vendor/autoload.php' ]
#     psr-4: { 'Acme\SkeletonDancer\': 'src/SkeletonDancer' }

# Register additional expression-language function providers.
# Each value of the `expression_language.function_providers` array
# must be a fully qualified class-name (as shown in the example).
#
# expression_language:
#     function_providers:
#         - 'Rollerworks\Tools\SkeletonDancer\ExpressionLanguage\StringProvider'