<?php
use CodeIgniter\HTTP\Header;
use CodeIgniter\CodeIgniter;

$errorId = uniqid('error', true);
?>
<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">
    <title><?= esc($title) ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#DC4814', // Brand primary from debug.css
                        'light-bg': '#ededee',
                        'dark-bg': '#404040',
                        'dark-text': '#222',
                        'light-text': '#c7c7c7',
                    }
                }
            }
        }
    </script>


    <script>
        <?= file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'debug.js') ?>
    </script>
</head>
<body onload="init()" class="bg-white text-gray-600 font-light font-sans leading-normal">

    <!-- Header -->
    <div class="bg-light-bg text-dark-text mt-8">
        <div class="bg-primary text-white text-center p-2 fixed top-0 w-full z-10">
            Displayed at <?= esc(date('H:i:s')) ?> &mdash;
            PHP: <?= esc(PHP_VERSION) ?>  &mdash;
            CodeIgniter: <?= esc(CodeIgniter::CI_VERSION) ?> --
            Environment: <?= ENVIRONMENT ?>
        </div>
        <div class="container mx-auto max-w-6xl p-4 pt-10">
            <h1 class="text-4xl font-medium mt-4 mb-2"><?= esc($title), esc($exception->getCode() ? ' #' . $exception->getCode() : '') ?></h1>
            <p class="text-xl leading-relaxed">
                <?= nl2br(esc($exception->getMessage())) ?>
                <a href="https://www.duckduckgo.com/?q=<?= urlencode($title . ' ' . preg_replace('#\'.*\'|".*"#Us', '', $exception->getMessage())) ?>"
                   rel="noreferrer" target="_blank" class="text-primary hover:underline ml-4 text-base">search &rarr;</a>
            </p>
        </div>
    </div>

    <!-- Source -->
    <div class="container mx-auto max-w-6xl p-4">
        <p><b><?= esc(clean_path($file)) ?></b> at line <b><?= esc($line) ?></b></p>

        <?php if (is_file($file)) : ?>
            <div class="bg-zinc-800 text-gray-300 p-4 rounded font-mono text-sm overflow-x-auto mt-2 [&_.highlight]:block [&_.highlight]:bg-[#222] [&_.highlight]:text-[#c7c7c7] [&_.highlight_.number]:text-white">
                <?= static::highlightFile($file, $line, 15); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="container mx-auto max-w-6xl p-4">
        <?php
        $last = $exception;

        while ($prevException = $last->getPrevious()) {
            $last = $prevException;
            ?>

    <pre class="bg-light-bg border border-gray-200 p-4 rounded mt-4 overflow-x-auto">
    Caused by:
    <?= esc($prevException::class), esc($prevException->getCode() ? ' #' . $prevException->getCode() : '') ?>

    <?= nl2br(esc($prevException->getMessage())) ?>
    <a href="https://www.duckduckgo.com/?q=<?= urlencode($prevException::class . ' ' . preg_replace('#\'.*\'|".*"#Us', '', $prevException->getMessage())) ?>"
       rel="noreferrer" target="_blank" class="text-primary hover:underline">search &rarr;</a>
    <?= esc(clean_path($prevException->getFile()) . ':' . $prevException->getLine()) ?>
    </pre>

        <?php
        }
        ?>
    </div>

    <?php if (defined('SHOW_DEBUG_BACKTRACE') && SHOW_DEBUG_BACKTRACE) : ?>
    <div class="container mx-auto max-w-6xl p-4 mt-8">

        <ul class="flex border-b border-gray-300 mb-0 list-none pl-0 bg-light-bg rounded-t" id="tabs">
            <li><a href="#backtrace" class="inline-block py-3 px-4 text-dark-text hover:bg-white border hover:border-b-0 border-transparent rounded-t">Backtrace</a></li>
            <li><a href="#server" class="inline-block py-3 px-4 text-dark-text hover:bg-white border hover:border-b-0 border-transparent rounded-t">Server</a></li>
            <li><a href="#request" class="inline-block py-3 px-4 text-dark-text hover:bg-white border hover:border-b-0 border-transparent rounded-t">Request</a></li>
            <li><a href="#response" class="inline-block py-3 px-4 text-dark-text hover:bg-white border hover:border-b-0 border-transparent rounded-t">Response</a></li>
            <li><a href="#files" class="inline-block py-3 px-4 text-dark-text hover:bg-white border hover:border-b-0 border-transparent rounded-t">Files</a></li>
            <li><a href="#memory" class="inline-block py-3 px-4 text-dark-text hover:bg-white border hover:border-b-0 border-transparent rounded-t">Memory</a></li>
        </ul>

        <div class="tab-content bg-white border border-gray-300 border-t-0 p-4">

            <!-- Backtrace -->
            <div class="content block" id="backtrace">

                <ol class="list-decimal pl-8">
                <?php foreach ($trace as $index => $row) : ?>

                    <li class="mb-2">
                        <p>
                            <!-- Trace info -->
                            <?php if (isset($row['file']) && is_file($row['file'])) : ?>
                                <?php
                                if (isset($row['function']) && in_array($row['function'], ['include', 'include_once', 'require', 'require_once'], true)) {
                                    echo esc($row['function'] . ' ' . clean_path($row['file']));
                                } else {
                                    echo esc(clean_path($row['file']) . ' : ' . $row['line']);
                                }
                                ?>
                            <?php else: ?>
                                {PHP internal code}
                            <?php endif; ?>

                            <!-- Class/Method -->
                            <?php if (isset($row['class'])) : ?>
                                &nbsp;&nbsp;&mdash;&nbsp;&nbsp;<?= esc($row['class'] . $row['type'] . $row['function']) ?>
                                <?php if (! empty($row['args'])) : ?>
                                    <?php $argsId = $errorId . 'args' . $index ?>
                                    ( <a href="#" onclick="return toggle('<?= esc($argsId, 'attr') ?>');" class="text-primary hover:underline">arguments</a> )
                                    <div class="hidden ml-4 mt-2" id="<?= esc($argsId, 'attr') ?>">
                                        <table cellspacing="0" class="w-auto">
                                        <?php
                                        $params = null;
                                        // Reflection by name is not available for closure function
                                        if (! str_ends_with($row['function'], '}')) {
                                            $mirror = isset($row['class']) ? new ReflectionMethod($row['class'], $row['function']) : new ReflectionFunction($row['function']);
                                            $params = $mirror->getParameters();
                                        }

                                        foreach ($row['args'] as $key => $value) : ?>
                                            <tr>
                                                <td class="pr-4 font-mono text-sm text-gray-600"><code><?= esc(isset($params[$key]) ? '$' . $params[$key]->name : "#{$key}") ?></code></td>
                                                <td><pre class="bg-light-bg px-2 py-1 rounded text-sm"><?= esc(print_r($value, true)) ?></pre></td>
                                            </tr>
                                        <?php endforeach ?>
                                        </table>
                                    </div>
                                <?php else : ?>
                                    ()
                                <?php endif; ?>
                            <?php endif; ?>

                            <?php if (! isset($row['class']) && isset($row['function'])) : ?>
                                &nbsp;&nbsp;&mdash;&nbsp;&nbsp;    <?= esc($row['function']) ?>()
                            <?php endif; ?>
                        </p>

                        <!-- Source? -->
                        <?php if (isset($row['file']) && is_file($row['file']) && isset($row['class'])) : ?>
                            <div class="bg-light-bg p-2 rounded text-sm overflow-x-auto mt-1 [&_.highlight]:block [&_.highlight]:bg-[#222] [&_.highlight]:text-[#c7c7c7] [&_.highlight_.number]:text-white">
                                <?= static::highlightFile($row['file'], $row['line']) ?>
                            </div>
                        <?php endif; ?>
                    </li>

                <?php endforeach; ?>
                </ol>

            </div>

            <!-- Server -->
            <div class="content hidden" id="server">
                <?php foreach (['_SERVER', '_SESSION'] as $var) : ?>
                    <?php
                    if (empty($GLOBALS[$var]) || ! is_array($GLOBALS[$var])) {
                        continue;
                    } ?>

                    <h3 class="text-xl font-medium mt-4 mb-2 border-b pb-1">$<?= esc($var) ?></h3>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b border-gray-200 py-2">Key</th>
                                <th class="border-b border-gray-200 py-2">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($GLOBALS[$var] as $key => $value) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-1 pr-4 align-top font-medium text-gray-700"><?= esc($key) ?></td>
                                <td class="py-1 align-top">
                                    <?php if (is_string($value)) : ?>
                                        <div class="break-all"><?= esc($value) ?></div>
                                    <?php else: ?>
                                        <pre class="bg-light-bg p-2 rounded text-sm overflow-x-auto"><?= esc(print_r($value, true)) ?></pre>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php endforeach ?>

                <!-- Constants -->
                <?php $constants = get_defined_constants(true); ?>
                <?php if (! empty($constants['user'])) : ?>
                    <h3 class="text-xl font-medium mt-4 mb-2 border-b pb-1">Constants</h3>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b border-gray-200 py-2">Key</th>
                                <th class="border-b border-gray-200 py-2">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($constants['user'] as $key => $value) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-1 pr-4 align-top font-medium text-gray-700"><?= esc($key) ?></td>
                                <td class="py-1 align-top">
                                    <?php if (is_string($value)) : ?>
                                        <div class="break-all"><?= esc($value) ?></div>
                                    <?php else: ?>
                                        <pre class="bg-light-bg p-2 rounded text-sm overflow-x-auto"><?= esc(print_r($value, true)) ?></pre>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <!-- Request -->
            <div class="content hidden" id="request">
                <?php $request = service('request'); ?>

                <table class="w-full text-left border-collapse">
                    <tbody>
                        <tr class="hover:bg-gray-50"><td class="py-1 pr-4 font-medium w-40">Path</td><td><?= esc($request->getUri()) ?></td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-1 pr-4 font-medium">HTTP Method</td><td><?= esc($request->getMethod()) ?></td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-1 pr-4 font-medium">IP Address</td><td><?= esc($request->getIPAddress()) ?></td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-1 pr-4 font-medium">Is AJAX Request?</td><td><?= $request->isAJAX() ? 'yes' : 'no' ?></td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-1 pr-4 font-medium">Is CLI Request?</td><td><?= $request->isCLI() ? 'yes' : 'no' ?></td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-1 pr-4 font-medium">Is Secure Request?</td><td><?= $request->isSecure() ? 'yes' : 'no' ?></td></tr>
                        <tr class="hover:bg-gray-50"><td class="py-1 pr-4 font-medium">User Agent</td><td><?= esc($request->getUserAgent()->getAgentString()) ?></td></tr>
                    </tbody>
                </table>

                <?php $empty = true; ?>
                <?php foreach (['_GET', '_POST', '_COOKIE'] as $var) : ?>
                    <?php
                    if (empty($GLOBALS[$var]) || ! is_array($GLOBALS[$var])) {
                        continue;
                    } ?>

                    <?php $empty = false; ?>

                    <h3 class="text-xl font-medium mt-4 mb-2 border-b pb-1">$<?= esc($var) ?></h3>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b border-gray-200 py-2">Key</th>
                                <th class="border-b border-gray-200 py-2">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($GLOBALS[$var] as $key => $value) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-1 pr-4 align-top font-medium text-gray-700"><?= esc($key) ?></td>
                                <td class="py-1 align-top">
                                    <?php if (is_string($value)) : ?>
                                        <div class="break-all"><?= esc($value) ?></div>
                                    <?php else: ?>
                                        <pre class="bg-light-bg p-2 rounded text-sm overflow-x-auto"><?= esc(print_r($value, true)) ?></pre>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach ?>

                <?php if ($empty) : ?>
                    <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded mt-4 text-center">
                        No $_GET, $_POST, or $_COOKIE Information to show.
                    </div>
                <?php endif; ?>

                <?php $headers = $request->headers(); ?>
                <?php if (! empty($headers)) : ?>

                    <h3 class="text-xl font-medium mt-4 mb-2 border-b pb-1">Headers</h3>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b border-gray-200 py-2">Header</th>
                                <th class="border-b border-gray-200 py-2">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($headers as $name => $value) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-1 pr-4 align-top font-medium text-gray-700"><?= esc($name, 'html') ?></td>
                                <td class="py-1 align-top">
                                <?php
                                if ($value instanceof Header) {
                                    echo esc($value->getValueLine(), 'html');
                                } else {
                                    foreach ($value as $i => $header) {
                                        echo ' ('. $i+1 . ') ' . esc($header->getValueLine(), 'html');
                                    }
                                }
                                ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>

                <?php endif; ?>
            </div>

            <!-- Response -->
            <?php
                $response = service('response');
                $response->setStatusCode(http_response_code());
            ?>
            <div class="content hidden" id="response">
                <table class="w-full text-left border-collapse">
                    <tr class="hover:bg-gray-50">
                        <td class="py-1 pr-4 font-medium w-40">Response Status</td>
                        <td><?= esc($response->getStatusCode() . ' - ' . $response->getReasonPhrase()) ?></td>
                    </tr>
                </table>

                <?php $headers = $response->headers(); ?>
                <?php if (! empty($headers)) : ?>
                    <h3 class="text-xl font-medium mt-4 mb-2 border-b pb-1">Headers</h3>

                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr>
                                <th class="border-b border-gray-200 py-2">Header</th>
                                <th class="border-b border-gray-200 py-2">Value</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($headers as $name => $value) : ?>
                            <tr class="hover:bg-gray-50">
                                <td class="py-1 pr-4 align-top font-medium text-gray-700"><?= esc($name, 'html') ?></td>
                                <td class="py-1 align-top">
                                <?php
                                if ($value instanceof Header) {
                                    echo esc($response->getHeaderLine($name), 'html');
                                } else {
                                    foreach ($value as $i => $header) {
                                        echo ' ('. $i+1 . ') ' . esc($header->getValueLine(), 'html');
                                    }
                                }
                                ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>

            <!-- Files -->
            <div class="content hidden" id="files">
                <?php $files = get_included_files(); ?>

                <ol class="list-decimal pl-8">
                <?php foreach ($files as $file) :?>
                    <li class="mb-1 text-sm font-mono"><?= esc(clean_path($file)) ?></li>
                <?php endforeach ?>
                </ol>
            </div>

            <!-- Memory -->
            <div class="content hidden" id="memory">
                <table class="w-full text-left border-collapse">
                    <tbody>
                        <tr class="hover:bg-gray-50">
                            <td class="py-1 pr-4 font-medium">Memory Usage</td>
                            <td><?= esc(static::describeMemory(memory_get_usage(true))) ?></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="py-1 pr-4 font-medium">Peak Memory Usage:</td>
                            <td><?= esc(static::describeMemory(memory_get_peak_usage(true))) ?></td>
                        </tr>
                        <tr class="hover:bg-gray-50">
                            <td class="py-1 pr-4 font-medium">Memory Limit:</td>
                            <td><?= esc(ini_get('memory_limit')) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>  <!-- /tab-content -->

    </div> <!-- /container -->
    <?php endif; ?>

</body>
</html>
