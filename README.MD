## PHP7 Tool library

#File

- create directory
- check if file is readable/writable

#TypedEnum

class DayType extends TypedEnum
{

    public static function Monday()
    {
        return self::_create(0);
    }
    public static function Tuesday()
        {
            return self::_create(1);
        }

}

# Run PHPStan

docker run -it -v .:/app -w /app --rm attlaz/php:8.1 composer run-script phpstan
