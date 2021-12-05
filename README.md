# csv-query
A tool to query CSV files using SQL.

This tool is powered by [PHP MySQL Engine](https://github.com/vimeo/php-mysql-engine). SQL syntax which is supported by PHP MySQL Engine is supported.

## Usage
### Basic usage
A query is given as the first argument of the command. Data is read from stdin by default.
```console
$ cat data.csv
id,name
1,John
2,Alice
3,Dave
4,Bob
$ csv-query 'SELECT * FROM stdin WHERE id < 4 ORDER BY name' < data.csv
id,name
2,Alice
3,Dave
1,John
```

### Common options
```console
$ cat data.csv
1	John
2	Alice
3	Dave
4	Bob
$ csv-query -H --delimiter=$'\t' 'SELECT MIN(c1), MAX(c1) FROM stdin' < data.csv
min	max
1	4
```

### Joining tables
`csv-query` can get file paths as second and subsequent arguments. The file's base name (without extension) will be a table name.
```console
$ cat /path/to/user.csv
id,name
1,John
2,Alice
3,Dave
$ cat /another/dir/birthday.csv
user_id,birthday
1,2000/11/1
3,2002/6/5
$ csv-query 'SELECT name, birthday FROM user INNER JOIN birthday ON user.id = birthday.user_id' /path/to/user.csv /another/dir/birthday.csv
name,birthday
John,2000/11/01
Dave,2002/06/05
```

## Options
### `-d`, `--delimiter`
CSV delimiters used for both input and output. Default value is comma (`,`).

### `--delimiter-in`, `--delimiter-out`
CSV delimiters used for input and output, respectively. These options override `-d` option.

### `-H`, `--no-header-in`
Declares that the first line of the input is not a header line. Each column is named `c1`, `c2`, `c3`, and so on.

### `-O`, `--no-header-out`
Suppresses to print a header line.

### `-V`, `--version`
Outputs version number and exits.

### `--help`
Outputs a help message and exits.
