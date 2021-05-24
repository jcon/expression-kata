#/bin/sh

composer update && \
  composer dump-autoload && \
  echo "✅ Successfully bootstrapped!"