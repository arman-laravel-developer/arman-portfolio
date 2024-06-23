<?php
/**
 * Update the .env file with given key-value pairs.
 *
 * @param array $data
 * @return void
 */
function updateEnv(array $data)
{
    $path = base_path('.env');

    if (file_exists($path)) {
        $env = file_get_contents($path);

        foreach ($data as $key => $value) {
            $key = strtoupper($key);
            $value = '"' . $value . '"';

            if (preg_match("/^{$key}=/m", $env)) {
                $env = preg_replace("/^{$key}=.*/m", "{$key}={$value}", $env);
            } else {
                $env .= "\n{$key}={$value}";
            }
        }

        file_put_contents($path, $env);
    }
}
