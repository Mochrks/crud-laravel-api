<?php

namespace App\Utils;

class MinioUrlUtils
{
    public static function getMinioUrl($filename)
    {
        if (empty($filename)) {
            return null;
        }

        $minioEndpoint = config('filesystems.disks.minio.endpoint');
        $bucketName = config('filesystems.disks.minio.bucket');
        $region = 'us-east-1';
        $accessKey = config('filesystems.disks.minio.key');
        $secretKey = config('filesystems.disks.minio.secret');

        $client = new \Aws\S3\S3Client([
            'version' => 'latest',
            'region' => $region,
            'endpoint' => $minioEndpoint,
            'use_path_style_endpoint' => true,
            'credentials' => [
                'key' => $accessKey,
                'secret' => $secretKey,
            ],
        ]);

        $command = $client->getCommand('GetObject', [
            'Bucket' => $bucketName,
            'Key' => $filename,
        ]);

        $request = $client->createPresignedRequest($command, '+5 minutes');

        return (string) $request->getUri();
    }
}
