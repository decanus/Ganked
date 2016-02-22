class LovelyBox
  module Runners
    class Services
      #
      # @param [Array] services
      #
      def self.run(services)
        services.each do |s|
           system(Shellwords.join(['service', s, 'start']))
        end
      end
    end
  end
end