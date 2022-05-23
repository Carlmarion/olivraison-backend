<?php

namespace App\Tests\Factory;

use DateTimeImmutable;
use App\Entity\Commande;
use Zenstruck\Foundry\Proxy;
use Zenstruck\Foundry\ModelFactory;
use App\Tests\Factory\AdresseFactory;
use App\Repository\CommandeRepository;
use Zenstruck\Foundry\RepositoryProxy;

/**
 * @extends ModelFactory<Commande>
 *
 * @method static Commande|Proxy createOne(array $attributes = [])
 * @method static Commande[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Commande|Proxy find(object|array|mixed $criteria)
 * @method static Commande|Proxy findOrCreate(array $attributes)
 * @method static Commande|Proxy first(string $sortedField = 'id')
 * @method static Commande|Proxy last(string $sortedField = 'id')
 * @method static Commande|Proxy random(array $attributes = [])
 * @method static Commande|Proxy randomOrCreate(array $attributes = [])
 * @method static Commande[]|Proxy[] all()
 * @method static Commande[]|Proxy[] findBy(array $attributes)
 * @method static Commande[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Commande[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static CommandeRepository|RepositoryProxy repository()
 * @method Commande|Proxy create(array|callable $attributes = [])
 */
final class CommandeFactory extends ModelFactory
{
    public function __construct()
    {
        parent::__construct();

        // TODO inject services if required (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services)
    }

    protected function getDefaults(): array
    {
        return [
            // TODO add your default values here (https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories)
            'updatedAt' => DateTimeImmutable::createFromMutable(self::faker()->datetime()),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->datetime()),
            'adresse' => AdresseFactory::createOne()
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Commande $commande): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Commande::class;
    }
}
