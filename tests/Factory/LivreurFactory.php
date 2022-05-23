<?php

namespace App\Tests\Factory;

use App\Entity\Livreur;
use App\Repository\LivreurRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Livreur>
 *
 * @method static Livreur|Proxy createOne(array $attributes = [])
 * @method static Livreur[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Livreur|Proxy find(object|array|mixed $criteria)
 * @method static Livreur|Proxy findOrCreate(array $attributes)
 * @method static Livreur|Proxy first(string $sortedField = 'id')
 * @method static Livreur|Proxy last(string $sortedField = 'id')
 * @method static Livreur|Proxy random(array $attributes = [])
 * @method static Livreur|Proxy randomOrCreate(array $attributes = [])
 * @method static Livreur[]|Proxy[] all()
 * @method static Livreur[]|Proxy[] findBy(array $attributes)
 * @method static Livreur[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Livreur[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static LivreurRepository|RepositoryProxy repository()
 * @method Livreur|Proxy create(array|callable $attributes = [])
 */
final class LivreurFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            'user' => UserFactory::createOne()
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Livreur $livreur): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Livreur::class;
    }
}
