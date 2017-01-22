# Directory Documentation

`\Greg\Support\Dir` is working with directories.

# Methods:

* [make](#make) - Make a directory;
* [unlink](#unlink) - Remove a directory;
* [copy](#copy) - Copy a directory.

## make

Make a directory.

```php
make(string $dir, boolean $recursive = false): boolean
```

`$dir` - Directory;  
`$recursive` - Make recursive.

_Example:_

```php
\Greg\Support\Dir::make(__DIR__ . '/storage');
```

## unlink

Remove a directory.

```php
unlink(string $dir): boolean
```

`$dir` - Directory.

_Example:_

```php
\Greg\Support\Dir::unlink(__DIR__ . '/storage');
```

## copy

Copy a directory.

```php
copy(string $source, string $destination, int $permissions = 0755): boolean
```

`$source` - Source folder;  
`$destination` - Destination folder;  
`$permissions` - Permissions.

_Example:_

```php
\Greg\Support\Dir::copy(__DIR__ . '/storage', __DIR__ . '/tmp');
```
