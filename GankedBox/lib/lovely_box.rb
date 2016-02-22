require 'yaml'
require 'pp'
require 'fileutils'
require 'net/http'
require 'shellwords'
require 'securerandom'

require_relative 'lovely_box/runners/yum'
require_relative 'lovely_box/runners/rubygems'
require_relative 'lovely_box/runners/downloads'
require_relative 'lovely_box/runners/pecl'
require_relative 'lovely_box/runners/file_actions'
require_relative 'lovely_box/runners/commands'
require_relative 'lovely_box/runners/services'

require_relative 'lovely_box/cli'
require_relative 'lovely_box/config'
require_relative 'lovely_box/provision'
require_relative 'lovely_box/boot'


class LovelyBox
  class << self
    #
    # @return [String]
    #
    attr_accessor :root
  end

  def self.ensure_user_config
    user_config = File.join(LovelyBox.root, 'lovelybox.yml')

    unless File.exist?(user_config)
      FileUtils.copy File.join(LovelyBox.root, 'conf/lovelybox/local.yml'), user_config
    end
  end
end
