<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitb1fec733da2e97cc3a59ec9634c1cc07
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Tests\\' => 6,
        ),
        'O' => 
        array (
            'OpenTransposh\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Tests\\' => 
        array (
            0 => __DIR__ . '/../..' . '/tests',
        ),
        'OpenTransposh\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'OpenTransposh\\Ajax_Controller' => __DIR__ . '/../..' . '/src/Ajax_Controller.php',
        'OpenTransposh\\Backup' => __DIR__ . '/../..' . '/src/Backup.php',
        'OpenTransposh\\Core\\Constants' => __DIR__ . '/../..' . '/src/Core/Constants.php',
        'OpenTransposh\\Core\\Parser' => __DIR__ . '/../..' . '/src/Core/Parser.php',
        'OpenTransposh\\Core\\Parser_Stats' => __DIR__ . '/../..' . '/src/Core/Parser_Stats.php',
        'OpenTransposh\\Core\\Utilities' => __DIR__ . '/../..' . '/src/Core/Utilities.php',
        'OpenTransposh\\Database' => __DIR__ . '/../..' . '/src/Database.php',
        'OpenTransposh\\Editor_Table' => __DIR__ . '/../..' . '/src/Editor_Table.php',
        'OpenTransposh\\Integrations' => __DIR__ . '/../..' . '/src/Integrations.php',
        'OpenTransposh\\Legacy\\Legacy_Adapter' => __DIR__ . '/../..' . '/src/Legacy/Legacy_Adapter.php',
        'OpenTransposh\\Legacy\\Legacy_Usage_Reporter' => __DIR__ . '/../..' . '/src/Legacy/Legacy_Usage_Reporter.php',
        'OpenTransposh\\Libraries\\SimpleHtmlDom\\Constants' => __DIR__ . '/../..' . '/src/Libraries/SimpleHtmlDom/Constants.php',
        'OpenTransposh\\Libraries\\SimpleHtmlDom\\Node' => __DIR__ . '/../..' . '/src/Libraries/SimpleHtmlDom/Node.php',
        'OpenTransposh\\Libraries\\SimpleHtmlDom\\Simple_Html_Dom' => __DIR__ . '/../..' . '/src/Libraries/SimpleHtmlDom/Simple_Html_Dom.php',
        'OpenTransposh\\Logging\\LogLevel' => __DIR__ . '/../..' . '/src/Logging/LogLevel.php',
        'OpenTransposh\\Logging\\LogService' => __DIR__ . '/../..' . '/src/Logging/LogService.php',
        'OpenTransposh\\Logging\\Logger' => __DIR__ . '/../..' . '/src/Logging/Logger.php',
        'OpenTransposh\\Logging\\LoggerTrait' => __DIR__ . '/../..' . '/src/Logging/LoggerTrait.php',
        'OpenTransposh\\Logging\\NullLogger' => __DIR__ . '/../..' . '/src/Logging/NullLogger.php',
        'OpenTransposh\\Logging\\Query_Monitor_Logger' => __DIR__ . '/../..' . '/src/Logging/Query_Monitor_Logger.php',
        'OpenTransposh\\Mail' => __DIR__ . '/../..' . '/src/Mail.php',
        'OpenTransposh\\Option' => __DIR__ . '/../..' . '/src/Option.php',
        'OpenTransposh\\Plugin' => __DIR__ . '/../..' . '/src/Plugin.php',
        'OpenTransposh\\Plugin_Admin' => __DIR__ . '/../..' . '/src/Plugin_Admin.php',
        'OpenTransposh\\Plugin_Options' => __DIR__ . '/../..' . '/src/Plugin_Options.php',
        'OpenTransposh\\Post_Publish' => __DIR__ . '/../..' . '/src/Post_Publish.php',
        'OpenTransposh\\Traits\\Static_Instance_Trait' => __DIR__ . '/../..' . '/src/Traits/Static_Instance_Trait.php',
        'OpenTransposh\\Widgets\\Base_Widget' => __DIR__ . '/../..' . '/src/Widgets/Base_Widget.php',
        'OpenTransposh\\Widgets\\Plugin_Widget' => __DIR__ . '/../..' . '/src/Widgets/Plugin_Widget.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitb1fec733da2e97cc3a59ec9634c1cc07::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitb1fec733da2e97cc3a59ec9634c1cc07::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitb1fec733da2e97cc3a59ec9634c1cc07::$classMap;

        }, null, ClassLoader::class);
    }
}
