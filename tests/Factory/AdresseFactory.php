<?php

namespace App\Tests\Factory;

use App\Entity\Adresse;
use App\Repository\AdresseRepository;
use Zenstruck\Foundry\RepositoryProxy;
use Zenstruck\Foundry\ModelFactory;
use Zenstruck\Foundry\Proxy;

/**
 * @extends ModelFactory<Adresse>
 *
 * @method static Adresse|Proxy createOne(array $attributes = [])
 * @method static Adresse[]|Proxy[] createMany(int $number, array|callable $attributes = [])
 * @method static Adresse|Proxy find(object|array|mixed $criteria)
 * @method static Adresse|Proxy findOrCreate(array $attributes)
 * @method static Adresse|Proxy first(string $sortedField = 'id')
 * @method static Adresse|Proxy last(string $sortedField = 'id')
 * @method static Adresse|Proxy random(array $attributes = [])
 * @method static Adresse|Proxy randomOrCreate(array $attributes = [])
 * @method static Adresse[]|Proxy[] all()
 * @method static Adresse[]|Proxy[] findBy(array $attributes)
 * @method static Adresse[]|Proxy[] randomSet(int $number, array $attributes = [])
 * @method static Adresse[]|Proxy[] randomRange(int $min, int $max, array $attributes = [])
 * @method static AdresseRepository|RepositoryProxy repository()
 * @method Adresse|Proxy create(array|callable $attributes = [])
 */
final class AdresseFactory extends ModelFactory
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
            'numero_rue' => self::faker()->unique()->buildingNumber(),
            'rue' => self::faker()->unique()->streetName(),
            'ville' => self::faker()->unique()->city(),
            'code_postal' => self::faker()->unique()->postcode(),
        ];
    }

    protected function initialize(): self
    {
        // see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
        return $this
            // ->afterInstantiate(function(Adresse $adresse): void {})
        ;
    }

    protected static function getClass(): string
    {
        return Adresse::class;
    }
}
