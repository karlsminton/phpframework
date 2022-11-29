<?php

declare(strict_types=1);

namespace Phpframework\Pages\Model;

use Cycle\Database\Config\DatabaseConfig;
use Cycle\Database\Config\MySQL\TcpConnectionConfig;
use Cycle\Database\Config\MySQLDriverConfig;
use Cycle\Database\DatabaseManager;
use Cycle\ORM\EntityManager;
use Cycle\ORM\Factory;
use Cycle\ORM\ORM;
use Cycle\ORM\Schema;
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\SchemaInterface;

class PageRepository
{
//    /**
//     * @var ORM
//     */
//    private $orm;
//
//    /**
//     * @var EntityManager
//     */
//    private $entityManager;
//
//    /**
//     * @param ORM $orm
//     * @param EntityManager $entityManager
//     */
//    public function __construct(
//        ORM $orm,
//        EntityManager $entityManager
//    ) {
//        $this->orm = $orm;
//        $this->entityManager = $entityManager;
//    }

    /**
     * @param int $id
     * @return Page
     */
    public function getPageById(int $id): Page
    {
        $orm = $this->getOrm();
        /** @var Page $page */
        $page = $orm->getRepository(Page::class)->findByPK($id);
        return $page;
    }

    public function generateMigrations(): void
    {
        $db = $this->getDatabaseManager();
        $config = new \Cycle\Migrations\Config\MigrationConfig([
            'directory' => __DIR__ . '/../migrations/',
            'table' => 'migrations',
            'safe' => true
        ]);

        $migrator = new \Cycle\Migrations\Migrator($config, $db, new \Cycle\Migrations\FileRepository($config));
        $migrator->configure();

        $registry = new \Cycle\Schema\Registry($db);
        $registry->register();

        $generator = new \Cycle\Schema\Generator\Migrations\GenerateMigrations($migrator->getRepository(), $migrator->getConfig());

        // Migration generator creates set of migrations needed to sync database schema with desired state.
        // Each database will receive it's own migration.
        $generator->run($registry);
    }

    /**
     * @return ORM
     */
    private function getOrm(): ORM
    {
        $db = $this->getDatabaseManager();
        $orm = new ORM(new Factory($db), new Schema([
            'page' => [
                SchemaInterface::MAPPER => Mapper::class,
                SchemaInterface::ENTITY => Page::class,
                SchemaInterface::DATABASE => 'phpframework',
                SchemaInterface::TABLE => 'pages',
                SchemaInterface::PRIMARY_KEY => 'id',
                SchemaInterface::COLUMNS => [
                    'id' => 'id',
                    'name' => 'name',
                ],
                SchemaInterface::TYPECAST => [
                    'id' => 'int',
                ],
                SchemaInterface::RELATIONS => [],
            ]
        ]));

        return $orm;
    }

    /**
     * @return DatabaseManager
     */
    private function getDatabaseManager(): DatabaseManager
    {
        return new DatabaseManager(
            new DatabaseConfig([
                'default' => 'default',
                'databases' => [
                    'default' => ['connection' => 'mysql']
                ],
                'connections' => [
                    'mysql' => new MySQLDriverConfig(
                        connection: new TcpConnectionConfig('phpframework', 'db'),
                        queryCache: true,
                    ),
                ]
            ])
        );
    }
}