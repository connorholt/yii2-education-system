API_SERVICE_NAME=run

# define standard colors
ifneq (,$(findstring xterm,${TERM}))
	BLACK        := $(shell tput -Txterm setaf 0)
	RED          := $(shell tput -Txterm setaf 1)
	GREEN        := $(shell tput -Txterm setaf 2)
	YELLOW       := $(shell tput -Txterm setaf 3)
	LIGHTPURPLE  := $(shell tput -Txterm setaf 4)
	PURPLE       := $(shell tput -Txterm setaf 5)
	BLUE         := $(shell tput -Txterm setaf 6)
	WHITE        := $(shell tput -Txterm setaf 7)
	RESET := $(shell tput -Txterm sgr0)
else
	BLACK        := ""
	RED          := ""
	GREEN        := ""
	YELLOW       := ""
	LIGHTPURPLE  := ""
	PURPLE       := ""
	BLUE         := ""
	WHITE        := ""
	RESET        := ""
endif

# set target color
TARGET_COLOR := $(BLUE)

POUND = \#

colors: ## show all the colors
	@echo "${BLACK}BLACK${RESET}"
	@echo "${RED}RED${RESET}"
	@echo "${GREEN}GREEN${RESET}"
	@echo "${YELLOW}YELLOW${RESET}"
	@echo "${LIGHTPURPLE}LIGHTPURPLE${RESET}"
	@echo "${PURPLE}PURPLE${RESET}"
	@echo "${BLUE}BLUE${RESET}"
	@echo "${WHITE}WHITE${RESET}"

.PHONY: run
run:
	@echo "${LIGHTPURPLE}>> composer install ${RESET}"
	docker-compose run --rm php composer update --prefer-dist
	@echo "${LIGHTPURPLE}>> composer install ${RESET}"
	docker-compose run --rm php composer install
	@echo "${LIGHTPURPLE}>> docker-compose up -d ${RESET}"
	docker-compose up -d
	@echo "${LIGHTPURPLE}>> migrate ${RESET}"
	docker-compose run --rm php yii migrate/up
	@echo "${GREEN}>> finished ${RESET}"

.PHONY: down
down:
	@echo "${LIGHTPURPLE}>> composer install ${RESET}"
	docker-compose down -v

.PHONY: migrate-up
migrate-up:
	@echo "${LIGHTPURPLE}>> composer install ${RESET}"
	docker-compose run --rm php yii migrate/up