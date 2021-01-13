# Make all documentation
docs: apidocs userdocs
# Make the API docs
apidocs:
	php73 /opt/local/bin/doctum update ./doctum.config.php
# Make the user guide docs
userdocs:
	mkdocs build
# run phpunit tests
test:
	phpunit

userdocs-serve:
	mkdocs serve