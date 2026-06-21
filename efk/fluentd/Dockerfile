ARG FLUENTD_VERSION
FROM $FLUENTD_VERSION

USER root

RUN ["gem", "install", "elasticsearch", "--no-document", "--version", "7.17.7 "]
RUN ["gem", "install", "fluent-plugin-elasticsearch", "--no-document", "--version", "5.2.4"]

USER fluent
